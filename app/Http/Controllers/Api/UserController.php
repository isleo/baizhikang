<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Template, Event, Auth, Validator;
use App\Events\User\Login;
use App\Http\Requests\User\AuthRequest;
use App\Jobs\Base\UploadFile;
use Illuminate\Support\Facades\Redis as L_Redis;
use DB;

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
}