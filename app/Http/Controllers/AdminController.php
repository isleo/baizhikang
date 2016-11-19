<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class AdminController extends Controller
{
    public function login() {
    	return view('ace.login');
    }

    public function postLogin(Request $request) {
    	$username = $request->input('username');
    	$password = $request->input('password');
    	if ($username='admin' && $password='baizhikang') {
    		Session::put('username', $username);
    		return redirect('/admin/index');
    	} else {
    		return response('Unauthorized.', 401);
    	}
    }

    public function index() {
    	return view('ace.index');
    }
}
