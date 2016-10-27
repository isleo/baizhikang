<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tools\PushSDK;

class PushController extends Controller
{
    public function testPush() {
    	$sdk = new PushSDK();
    	dd($sdk);
    }
}
