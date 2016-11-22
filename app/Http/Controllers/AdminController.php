<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
use Tools\Page;

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

    public function index(Request $request) {
            $page = $request->input('page');
            $page = !empty($page) ? $page : 0;
            $rows = 2;
            $count = DB::table('bzk_device_info_log')->count();
            $deviceInfo = DB::table('bzk_device_info_log')->skip(($page-1) * $rows)->take($rows)->get();
            $userIdArr = DB::table('bzk_device_info_log')->skip(($page-1) * $rows)->take($rows)->lists('userId');
            $mobileArr = DB::table('bzk_user_info')->whereIn('id', $userIdArr)->lists('mobile', 'id');
            $data = [];
            foreach ($deviceInfo as $key => $value) {
                $data[$key]['id'] = $value->id;
                $data[$key]['deviceName'] = $value->deviceName;
                $data[$key]['type'] = $value->type;
                $data[$key]['mobile'] = $mobileArr[$value->userId]; 
                $data[$key]['createTime'] = $value->createTime;
            }
            $page = new Page($count, $rows);
            $showPage = $page->show();
            return view('ace.deviceInfo', ['data' => $data, 'showPage' => $showPage]);
    }

    public function userInfoIndex(Request $request) {
            $page = $request->input('page');
            $page = !empty($page) ? $page : 0;
            $rows = 2;
            $count = DB::table('bzk_user_info')->count();
            $userInfo = DB::table('bzk_user_info')->skip(($page-1) * $rows)->take($rows)->get();
            $userIdArr = DB::table('bzk_user_info')->skip(($page-1) * $rows)->take($rows)->lists('id');
            $bindIdArr = DB::table('bzk_user_relationship')->whereIn('userId', $userIdArr)->lists('relationId');
            $bindArr = DB::table('bzk_user_relationship')->whereIn('userId', $userIdArr)->get();
            $bindUserArr = DB::table('bzk_user_info')->whereIn('id', $bindIdArr)->lists('mobile', 'id');
            foreach ($userInfo as $key => $value) {
                $userInfo[$key]->bindId = [];
                foreach ($bindArr as $k => $v) {
                    if ($v->userId == $value->id) {
                        $userInfo[$key]->bindId[] = $v->relationId;
                    }
                }
                $userInfo[$key]->bindUser = [];
                foreach ($userInfo[$key]->bindId as $t => $s) {
                    foreach ($bindUserArr as $a => $b) {
                        if ($s == $a) {
                            $userInfo[$key]->bindUser[] = $b;
                        }
                    }
                }
            }
            $page = new Page($count, $rows);
            $showPage = $page->show();
            return view('ace.userInfo', ['data' => $userInfo, 'showPage' => $showPage]);
    }

    public function defriend(Request $request) {
            $id = $request->input('id');
            $status = $request->input('status');
            $deviceInfo = DB::table('bzk_user_info')->where('id', $id)->update(['status' => $status]);
            return redirect('/admin/userInfoIndex');
    }
}
