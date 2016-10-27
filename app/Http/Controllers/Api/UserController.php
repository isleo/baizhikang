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
        $res = $user->where('mobile', $mobile)->first();
        if (!empty($res)) {
            $resData = $user->where('mobile', $mobile)->where('password', $password)->first();
            if (!empty($resData)) {
                $data['loginTime'] = time();
                $data['id'] = $resData->id;
                $this->api_response['status'] = 0;
                $userData = $resData->toArray();
                $userData['loginTime'] = time();
                $this->api_response['msg'] = $userData;
                $user->updateUser($data);
            } else {
                $this->api_response['status'] = -2;
                $this->api_response['msg'] = '密码错误';
            }
        } else {
            $this->api_response['status'] = -1;
            $this->api_response['msg'] = '账号不存在';
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
        $res = $user->where('mobile', $data['mobile'])->first();
        $data['createTime'] = time();
        $resCode = $request->input('validateCode');
        $validateCode = Session::get('validateCode');
        if ($resCode != $validateCode) {
            $this->api_response['status'] = -3;
            $this->api_response['msg'] = '验证码错误';
        } else {
            if (empty($res)) {
                $id = $user->createUser($data);
                $this->api_response['status'] = 0;
                $this->api_response['msg'] = '注册成功';
            } else {
                $this->api_response['status'] = -2;
                $this->api_response['msg'] = '手机号已存在';
            }
        }
        return response()->json($this->api_response);
    }

    /**
     *  validate code
     */
    public function getValidateCode(Request $request)
    {
        $mobile = $request->input('mobile');
        if (empty($mobile)) {
            $retval['status'] = -3;
            $retval['msg'] = '手机号码为空';
            return response()->json($retval);
        }
        $umsCode = mt_rand(1000,9999);
        Session::put('validateCode', $umsCode);
        $c = new TopClient;
        $c->appkey = '23436766';
        $c->secretKey = 'a7d084b977413ee98f17b84e77c6ab8a';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName('爱拍test');
        $req->setSmsParam('{"number":"' . $umsCode . '"}');
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode('SMS_13200721');
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
}