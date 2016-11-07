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
        $token = checkToken($token);
        $data['deviceName'] = $request->input('deviceName');
        $item = $request->input('item');
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
            $data['userId'] = $token;
            $data['linkTime'] = time();
            $data['createTime'] = time();
            $deviceInfo = $device->createDevice($data);
            $deviceItem = $device->find($deviceInfo['id']);
            if (empty($resData)) {
                $retval['status'] = -3;
                $retval['msg'] = '该记录新建失败';
                return response()->json($retval);
            }
            $deviceItem->increment($item, 1, ['updateTime' => time()]);
            $retval['status'] = 0;
            $retval['msg'] = '更新成功';
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -4;
            $retval['msg'] = '操作失败';
            return response()->json($retval);
        }
    }

    public function getDeviceInfo(Request $request)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $deviceName = $request->input('deviceName');
        $item = $request->input('item');
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
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%m-%d %H') as days, sum($item)"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->get();
                    break;
                case 1:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%m-%d') as days, sum($item)"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->get();
                    break;
                case 2:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%u') as days, sum($item)"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->get();
                    break;
                case 3:
                    $data = DB::table('bzk_device_info_log')
                        ->select(DB::raw("from_unixtime(createTime, '%Y-%m') as days, sum($item)"))
                        ->where('userId', $token)
                        ->where('deviceName', $deviceName)
                        ->groupBy('days')
                        ->get();
                    break;
            }
            $retval['status'] = 0;
            $retval['msg'] = $data;
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = '操作失败';
            return response()->json($retval);
        }
    }
}
