<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Template, Event, Auth, Validator;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Support\Facades\Redis as L_Redis;
use DB;
use Session;
use Tools\TopClient;
use Tools\AlibabaAliqinFcSmsNumSendRequest;
use Model\User;
use Model\UserRelationship;
use Illuminate\Database\QueryException;

class UserController extends BaseController
{

    public function __construct() {
    	parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function login(Request $request, User $user)
    {
        $mobile = $request->input('mobile');
        $password = md5(md5($request->input('password')));
        try {
            $res = $user->where('mobile', $mobile)->first();
            if (empty($res)) {
                $this->api_response['status'] = -1;
                $this->api_response['msg'] = '账号不存在';
                return response()->json($this->api_response);
            }
            $resStatus = $user->where('mobile', $mobile)->where('status', 1)->first();
            if (empty($resStatus)) {
                $this->api_response['status'] = -2;
                $this->api_response['msg'] = '用户被拉黑';
                return response()->json($this->api_response);
            }
            $resData = $user->where('mobile', $mobile)->where('password', $password)->first();
            if (!empty($resData)) {
                $data['loginTime'] = time();
                $data['id'] = $resData->id;
                $user->updateUser($data);
                $this->api_response['status'] = 0;
                $userData = $resData->toArray();

                foreach ($userData as $key => $value) {
                    $userData[$key] = empty($value) || $value == NULL ? '' : $value;
                }
                $userData['loginTime'] = (string)time();
                $userData['userToken'] = generateToken($userData['id']);
                $this->api_response['msg'] = $userData;
            } else {
                $this->api_response['status'] = -3;
                $this->api_response['msg'] = '密码错误';
            }
        } catch (QueryException $e) {
            $this->api_response['status'] = -4;
            $this->api_response['msg'] = $e->getMessage();
        }
        return response()->json($this->api_response);
    }


    /**
     *  
     */
    public function register(AuthRegisterRequest $request, User $user)
    {
        $data['mobile'] = $request->input('mobile');
        $data['password'] = md5(md5($request->input('password')));
        try {
            $res = $user->where('mobile', $data['mobile'])->first();
            $data['createTime'] = time();
            $resCode = $request->input('validateCode');
            $validateCode = Session::get('validateCode');
            if (!isset($validateCode[$data['mobile']]) || $resCode != $validateCode[$data['mobile']]) {
                $this->api_response['status'] = -3;
                $this->api_response['msg'] = '验证码错误';
                return response()->json($this->api_response);
            }
            if (empty($res)) {
                $id = $user->createUser($data);
                $this->api_response['status'] = 0;
                $this->api_response['msg'] = '注册成功';
            } else {
                $this->api_response['status'] = -2;
                $this->api_response['msg'] = '手机号已注册';
            }
        } catch (QueryException $e) {
            $this->api_response['status'] = -4;
            $this->api_response['msg'] = $e->getMessage();
        }
        return response()->json($this->api_response);
    }

    /**
     *  validate code
     */
    public function getValidateCode(Request $request, User $user)
    {
        $mobile = $request->input('mobile');
        $type = $request->input('type');
        $token = $request->input('userToken');
        $token = checkToken($token);
        $userMobile = '';
        if (empty($mobile)) {
            $retval['status'] = -3;
            $retval['msg'] = '手机号码为空';
            return response()->json($retval);
        }
        if ($type == 2) {
            if ($token) {
                $resData = $user->where('status', 1)->where('id', $token)->first();
                if (!empty($resData)) {
                    $userMobile = $resData->mobile;
                }
            }        
        }
        $umsCode = mt_rand(1000,9999);
        $umsCodeArr = empty(Session::get('validateCode'))?[]:Session::get('validateCode');
        $umsCodeArr[$mobile] = $umsCode;
        Session::put('validateCode', $umsCodeArr);
        $c = new TopClient;
        $c->appkey = '23537819';
        $c->secretKey = 'e7c1599df0dd9aaa82b16ce89f18c9b1';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName('百智康');
        if ($type == 2) {
            $req->setSmsParam('{"code":"' . $umsCode . '", "phone":"'. $userMobile . '"}');
        } else {
            $req->setSmsParam('{"code":"' . $umsCode . '"}');
        }
        $req->setRecNum($mobile);
        switch ($type) {
            case 1:
                $template = 'SMS_26885049';
                break;
            case 2:
                $template = 'SMS_26930002';
                break;
            case 3:
                $template = 'SMS_26785017';
                break;
        }
        $req->setSmsTemplateCode($template);
        $resp = $c->execute($req);
        $msg =  json_decode(json_encode($resp), true);
        if (array_key_exists('result', $msg)) {
            if ($msg['result']['err_code'] == 0 && $msg['result']['success']) {
                $retval['status'] = 0;
                $retval['msg'] = '发送成功';
            } else {
                $retval['status'] = -1;
                $retval['msg'] = '发送失败';
            }
        } else {
            $retval['status'] = -2;
            $retval['msg'] = '发送失败,' . $msg['msg'];;
            if (isset($msg['sub_msg'])) {
                $retval['msg'] .= ':' . $msg['sub_msg'];
            }
        }
        return response()->json($retval);
    }

    public function uploadAvatar(Request $request, User $user)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                // $max_filesize = 2;
                // $filesize = $file->getSize();
                // $filesize /= 1000;
                // if ($max_filesize && $filesize > $max_filesize) {
                //     $this->api_response['status'] = -3;
                //     $this->api_response['msg'] = '文件大小不能超过' . ($max_filesize / 1000) . 'M！当前为' . round($filesize / 1000, 1) . 'M！';
                //     return response()->json($retval);
                // }

                $uploadPath = public_path() . '/data/';
                $extnames = ['jpg', 'jpeg', 'png'];
                $extName = $file->getClientOriginalExtension();
                $extName = strtolower($extName);
                if (in_array($extName, $extnames)) {
                    $fileName = $token . '.' . $extName;
                } else {
                    $retval['status'] = -4;
                    $retval['msg'] = '上传文件只能是（' . implode('|', $extnames) . '）文件!当前是' . $extName . '文件！';
                    return response()->json($retval);
                }

                try {
                    $state = $file->move($uploadPath, $fileName);
                } catch (FileException $e) {
                    $retval['status'] = -4;
                    $retval['msg'] = '文件保存错误!';
                    return response()->json($retval);
                }

                $retval['status'] = 0;
                $retval['msg'] = 'http://' . $request->getHttpHost() . '/data/' . $fileName;
                $data['id'] = $token;
                $data['avatar'] = $retval['msg'];
                $user->updateUser($data);
                return response()->json($retval);
            }
        } catch (QueryException $e) {
            $retval['status'] = -5;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }

    public function updateUserInfo(Request $request, User $user)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }

            $data = $request->except('mobile', 'password', 'status', 'loginTime', 'createTime', 'updateTime', 'userToken');
            $data['id'] = $token;
            $data['updateTime'] = time();
            $state = $user->updateUser($data);
            if ($state !== false) {
                $retval['status'] = 0;
                $retval['msg'] = '编辑成功';
                return response()->json($retval);
            } else {
                $retval['status'] = -3;
                $retval['msg'] = '编辑失败';
                return response()->json($retval);
            }
        } catch (QueryException $e) {
            $retval['status'] = -4;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }

    public function bindUser(Request $request, User $user, UserRelationship $relationship)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $mobile = $request->input('mobile');
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            $bindData = $user->where('status', 1)->where('mobile', $mobile)->first();
            if (empty($bindData)) {
                $retval['status'] = -3;
                $retval['msg'] = '关联用户不存在';
                return response()->json($retval);
            }
            $resCode = $request->input('validateCode');
            $validateCode = Session::get('validateCode');
            if (!isset($validateCode[$mobile]) || $resCode != $validateCode[$mobile]) {
                $retval['status'] = -4;
                $retval['msg'] = '验证码错误';
                return response()->json($retval);
            }
            $data['userId'] = $token;
            $data['relationId'] = $bindData->id;
            $data['createTime'] = time();
            $count = DB::table('bzk_user_relationship')->where('userId', $token)->count();
            if ($count >= 3) {
                $retval['status'] = -5;
                $retval['msg'] = '绑定用户已达到上限';
                return response()->json($retval);
            }
            $relationship->createRelationship($data);
            $retval['status'] = 0;
            $retval['msg'] = '绑定成功';
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -6;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }

    public function unbindUser(Request $request, User $user, UserRelationship $relationship)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $mobile = $request->input('mobile');
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            $bindData = $user->where('status', 1)->where('mobile', $mobile)->first();
            if (empty($bindData)) {
                $retval['status'] = -3;
                $retval['msg'] = '关联用户不存在';
                return response()->json($retval);
            }
            $resCode = $request->input('validateCode');
            $validateCode = Session::get('validateCode');
            if (!isset($validateCode[$mobile]) || $resCode != $validateCode[$mobile]) {
                $retval['status'] = -4;
                $retval['msg'] = '验证码错误';
                return response()->json($retval);
            }
            $data['userId'] = $token;
            $data['relationId'] = $bindData->id;
            $state = $relationship->delRelationship($data);
            if ($state != false ) {
                $retval['status'] = 0;
                $retval['msg'] = '解绑成功';
                return response()->json($retval);
            } else {
                $retval['status'] = -5;
                $retval['msg'] = '解绑失败';
                return response()->json($retval);
            }
        } catch (QueryException $e) {
            $retval['status'] = -6;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }

    /**
     *  
     */
    public function updatePassword(AuthRegisterRequest $request, User $user)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $data['mobile'] = $request->input('mobile');
        $data['password'] = md5(md5($request->input('password')));
        try {
            if (!$token) {
                $retval['status'] = -2;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -3;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            $data['updateTime'] = time();
            $resCode = $request->input('validateCode');
            $validateCode = Session::get('validateCode');
            if (!isset($validateCode[$data['mobile']]) || $resCode != $validateCode[$data['mobile']]) {
                $this->api_response['status'] = -4;
                $this->api_response['msg'] = '验证码错误';
                return response()->json($this->api_response);
            }
            $data['id'] = $res->id;
            unset($data['mobile']);
            $state = $user->updateUser($data);
            $this->api_response['status'] = 0;
            $this->api_response['msg'] = '修改密码成功';
        } catch (QueryException $e) {
            $this->api_response['status'] = -5;
            $this->api_response['msg'] = $e->getMessage();
        }
        return response()->json($this->api_response);
    }

    /**
     *  
     */
    public function addSuggestion(Request $request, User $user)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $data['mobile'] = $request->input('mobile');
        $data['content'] = $request->input('content');
        $data['createTime'] = time();
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            $state = DB::table('bzk_user_suggestion')->insert($data);
            $this->api_response['status'] = 0;
            $this->api_response['msg'] = '新增成功';
        } catch (QueryException $e) {
            $this->api_response['status'] = -3;
            $this->api_response['msg'] = $e->getMessage();
        }
        return response()->json($this->api_response);
    }

    /**
     *  
     */
    public function checkDownload(Request $request, User $user)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $type = $request->input('type');
        $version = $request->input('version');
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            $res = DB::table('bzk_download')->where('type', $type)->where('version', '>', $version)->first();
            if (empty($res)) {
                $this->api_response['status'] = -3;
                $this->api_response['msg'] = '无新版本';
            } else {
                $this->api_response['status'] = 0;
                $this->api_response['msg'] = '存在新版本';
                $this->api_response['data']['version'] = $res->version;
                $this->api_response['data']['url'] = $res->url;

            }
        } catch (QueryException $e) {
            $this->api_response['status'] = -4;
            $this->api_response['msg'] = $e->getMessage();
        }
        return response()->json($this->api_response);
    }

    public function getBindUser(Request $request, User $user, UserRelationship $relationship)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        // $token =1;
        try {
            if (!$token) {
                $retval['status'] = -1;
                $retval['msg'] = 'userToken出错';
                return response()->json($retval);
            }
            $resData = $user->where('status', 1)->where('id', $token)->first();
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该用户不存在';
                return response()->json($retval);
            }
            $relationUserIdArr = DB::table('bzk_user_relationship')->where('userId', $token)->lists('relationId');
            $relationUserArr = $user->whereIn('id', $relationUserIdArr)->select('mobile', 'nickname')->get();
            $retval['status'] = 0;
            $retval['msg'] = $relationUserArr;
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }


    public function Agreement(Request $request)
    {

        return view('agreement');
    }

}