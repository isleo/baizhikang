<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Model\User;
use Model\Device;
use DB;

class DeviceController extends Controller
{
    public function addDeviceLog(Request $request, User $user, Device $device)
    {
        $token = $request->input('userToken');
        $deviceName = $request->input('deviceName');
        $token = checkToken($token);
        $info = $request->input('info');
        return response()->json(['data' => $info]);
        $info = json_decode($info, true);
        try{
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
            if (empty($info)) {
                $retval['status'] = -4;
                $retval['msg'] = '设备监控数据为空';
                return response()->json($retval);
            }
            foreach ($info as $key => $value) {
                $value['deviceName'] = $deviceName;
                $value['userId'] = $token;
                $value['createTime'] = strtotime($value['time']);
                unset($value['time']);
                $deviceInfo = $device->createDevice($value);
            }
            $retval['status'] = 0;
            $retval['msg'] = '新增成功';
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }

    public function getDeviceInfo(Request $request, User $user)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $deviceName = $request->input('deviceName');
        $dateType = $request->input('dateType');
        try{
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
            switch ($dateType) {
                case 0:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%m-%d %H') as days, type, count(*) as frequency"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->groupBy('type')
                        ->get();
                    break;
                case 1:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%m-%d') as days, type, count(*) as frequency"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->groupBy('type')
                        ->get();
                    break;
                case 2:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%u') as days, type, count(*) as frequency"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->groupBy('type')
                        ->get();
                    break;
                case 3:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%m') as days, type, count(*) as frequency"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->groupBy('type')
                        ->get();
                    break;
            }
            $retval['status'] = 0;
            $retval['msg'] = $data;
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }
}
