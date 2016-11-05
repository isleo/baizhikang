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
    public function addDevice(Request $request, User $user, Device $device)
    {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $data['deviceName'] = $request->input('deviceName');
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
            $deviceInfo['deviceToken'] = generateToken($deviceInfo['id']);
            $retval['status'] = 0;
            $retval['msg'] = $deviceInfo;
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = '操作失败';
            return response()->json($retval);
        }
    }

    public function incrementItem(Request $request, Device $device)
    {
        $token = $request->input('deviceToken');
        $token = checkToken($token);
        $item = $request->input('item');
        try{
            if (!$token) {
                $retval['status'] = -1;
               $retval['msg'] = 'deviceToken出错';
               return response()->json($retval);
            }
            $resData = $device->find($token);
            if (empty($resData)) {
                $retval['status'] = -2;
                $retval['msg'] = '该设备名不存在';
                return response()->json($retval);
            }
            $deviceInfo = $device->find($token)->increment($item, 1, ['updateTime' => time()]);
            $retval['status'] = 0;
            $retval['msg'] = '更新成功';
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = '操作失败';
            return response()->json($retval);
        }
    }
}
