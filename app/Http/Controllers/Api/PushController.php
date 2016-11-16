<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tools\PushSDK;
use Model\User;
use Model\UserRelationship;

class PushController extends Controller
{
    
    public $sdk;
    public function __construct() {
        $this->sdk = createSDK();
    }

    public function testPush() {
        $msg = [
            'description' => 'notice msg',
        ];    
        $opts = [
            'msg_type' => 1,
        ];
        $rs = $this->sdk->queryMsgStatus('2601981450896765907');

        if($rs !== false){
            print_r($rs);
        }
    }

    public function pushMsgToSingleDevice(Request $request) {
        $deviceType = $request->input('deviceType');
        $msgType = $request->input('msgType');
        $msgText = $request->input('msgText');
        $channelId = $request->input('channelId');
        $this->sdk->setDeviceType($deviceType);
        $msg = '';
        switch($deviceType) {
            case 3:
    	    $msg = [
    	         'description' => $msgText,
    	    ];
    	    break;
    	case 4:
    	    $msg = [
    	        'aps' => [
             	"alert" => $msgText,
    	        ],
    	    ];
    	    break;
        }
        $opts = [
    	'msg_type' => $msgType,
        ];
        $rs = $this->sdk->pushMsgToSingleDevice($channelId, $msg,  $opts);
        if ($rs !== false) {
        	$retval['status'] = 0;
        	$retval['msg'] = $rs;
        } else {
        	$errMsg = $this->sdk -> getLastErrorMsg();
    	$errCode = $this->sdk -> getLastErrorCode();
    	$requestId = $this->sdk -> getRequestId();
        	$retval['status'] = $errCode;
        	$retval['msg'] = [
        	    'requestId' => $requestId,
        	    'errMsg' => $errMsg,
        	];
        }
        return response()->json($retval);
    }

    public function pushMsgToAll(Request $request) {
        $deviceType = $request->input('deviceType');
        $msgType = $request->input('msgType');
        $msgText = $request->input('msgText');
        $this->sdk->setDeviceType($deviceType);
        $msg = '';
        switch($deviceType) {
            case 3:
            $msg = [
                 'description' => $msgText,
            ];
            break;
        case 4:
            $msg = [
                'aps' => [
                    "alert" => $msgText,
                ],
            ];
            break;
        }
        $opts = [
            'msg_type' => (int)$msgType,
        ];
        $rs = $this->sdk->pushMsgToAll($msg,  $opts);
        if ($rs !== false) {
            $retval['status'] = 0;
            $retval['msg'] = $rs;
        } else {
            $errMsg = $this->sdk -> getLastErrorMsg();
            $errCode = $this->sdk -> getLastErrorCode();
            $requestId = $this->sdk -> getRequestId();
            $retval['status'] = $errCode;
            $retval['msg'] = [
                'requestId' => $requestId,
                'errMsg' => $errMsg,
            ];
        }
        return response()->json($retval);
    }

    public function pushBatchUniMsg(Request $request, User $user, UserRelationship $relationship) {
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
            $relationIdArr = $relationship->where('userId', $token)->lists('relationId')->toArray();
            if (!empty($relationIdArr)) {
                $pushId = $relationIdArr;
                $pushId[] = $token;
            } else {
                $pushId[] = $token;
            }
            $channelIdArr = $user->whereIn('id', $pushId)->where('status', 1)->where('isPush', 1)->lists('channelId')->toArray();
            if (empty($channelIdArr)) {
                $retval['status'] = 1;
                $retval['msg'] = '无可推送的channelId';
                return response()->json($retval);
            }
        } catch (QueryException $e) {
            $retval['status'] = -6;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
        $deviceType = $request->input('deviceType');
        $msgType = $request->input('msgType');
        $msgText = $request->input('msgText');
        $this->sdk->setDeviceType($deviceType);
        $msg = [];
        switch($deviceType) {
            case 3:
            $msg = [
                 'description' => $msgText,
            ];
            break;
        case 4:
            $msg = [
                'aps' => [
                    "alert" => $msgText,
                ],
            ];
            break;
        }
        $opts = [
            'msg_type' => (int)$msgType,
        ];
        $rs = $this->sdk->pushBatchUniMsg($channelIdArr, $msg, $opts);
        if ($rs !== false) {
            $retval['status'] = 0;
            $retval['msg'] = $rs;
        } else {
            $errMsg = $this->sdk -> getLastErrorMsg();
            $errCode = $this->sdk -> getLastErrorCode();
            $requestId = $this->sdk -> getRequestId();
            $retval['status'] = $errCode;
            $retval['msg'] = [
                'requestId' => $requestId,
                'errMsg' => $errMsg,
            ];
        }
        return response()->json($retval);
    }
}
