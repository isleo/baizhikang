<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis as L_Redis;
use App\Events\UserInfoEvent;
use Event;

class BaseController extends Controller
{
    /**
     * Json返回
     *
     */
    protected $api_response;

    protected function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        $this->api_response = [
            'status' => 0,
            'msg' => '',
        ];
    }
}
