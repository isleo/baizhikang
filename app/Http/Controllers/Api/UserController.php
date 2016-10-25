<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Template, Event, Auth, Validator;
use App\Events\User\Login;
use App\Http\Requests\User\AuthRequest;
use Illuminate\Support\Facades\Redis as L_Redis;
use DB;
use Session;
use Tools\TopClient;
use Tools\AlibabaAliqinFcSmsNumSendRequest;

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
    public function login(Request $request)
    {

    	return response()->json($this->api_response);
    }


    /**
     *  
     */
    public function register(Request $request)
    {

    	return response()->json($this->api_response);
    }

    /**
     *  validate code
     */
    public function getValidateCode(Request $request)
    {
        $mobile = $request->input('mobile');
        $umsCode = mt_rand(1000,9999);
        Session::put('umsCode', $umsCode);
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
                $retval['code'] = 0;
                $retval['msg'] = '发送成功';
            } else {
                $retval['code'] = -1;
                $retval['msg'] = '发送失败';
            }
        } else {
            $retval['code'] = -1;
            $retval['msg'] = '发送失败,' . $msg['msg'];;
            if (isset($msg['sub_msg'])) {
                $retval['msg'] .= ':' . $msg['sub_msg'];
            }
        }
        return response()->json($retval);
    }    
}