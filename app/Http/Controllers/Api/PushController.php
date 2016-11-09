<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tools\PushSDK;

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
}
