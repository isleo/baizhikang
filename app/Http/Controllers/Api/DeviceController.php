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
                if ($value['type'] == 1) {
                     $value['disconnect'] = $value['timelong'];
                }
                if (isset($value['timelong'])) {
                    unset($value['timelong']);   
                }
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
            $time = strtotime(date('Y-m-d', time()))  - 8 * 60 * 60;
            $dayTime = $time - 30 * 24 * 60 * 60;
            $weekTime = $time - 4 * 7 *24 * 60 * 60;
            $yearTime =$time - 365 * 24 * 60 * 60;
            $timeData = DB::table('bzk_device_info_log')
                    ->select(DB::raw("from_unixtime(createTime, '%H') as days, type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $time)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('days')
                    ->groupBy('type')
                    ->get();
            $timeCount = DB::table('bzk_device_info_log')
                    ->select(DB::raw("type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $time)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('type')
                    ->get();
            $dayData = DB::table('bzk_device_info_log')
                    ->select(DB::raw("from_unixtime(createTime, '%d') as days, type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $dayTime)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('days')
                    ->groupBy('type')
                    ->get();
            $dayCount = DB::table('bzk_device_info_log')
                    ->select(DB::raw("type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $dayTime)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('type')
                    ->get();
            $weekData = DB::table('bzk_device_info_log')
                    ->select(DB::raw("from_unixtime(createTime, '%u') as days, type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $weekTime)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('days')
                    ->groupBy('type')
                    ->get();
            $weekCount = DB::table('bzk_device_info_log')
                    ->select(DB::raw("type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $weekTime)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('type')
                    ->get();
            $yearData = DB::table('bzk_device_info_log')
                    ->select(DB::raw("from_unixtime(createTime, '%m') as days, type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $yearTime)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('days')
                    ->groupBy('type')
                    ->get();
            $yearCount = DB::table('bzk_device_info_log')
                    ->select(DB::raw("type, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $yearTime)
                    ->where('deviceName', $deviceName)
                    ->whereIn('type', [1,2,3,8])
                    ->groupBy('type')
                    ->get();
            $type = [
                1 => 'sensitive',
                2 =>  'move',
                3 => 'drop',
                8 => 'off',
            ];
            $info = [
                'hour' => [

                ],
                'day' => [

                ],
                'week' => [
                ],
                'year' => [

                ],
            ];
            foreach ($timeData as $key => $value) {
                $info['hour'][$type[$value->type]]['detail'][] = [
                'time' => $value->days,
                'frequency' => $value->frequency,
                ];
                // $info['hour'][$type[$value->type]]['detail'][]['frequency'] = $value->frequency;
                foreach ($timeCount as $k => $v) {
                    if ($value->type == $v->type) {
                        $info['hour'][$type[$value->type]]['count'] = $v->frequency;
                    }
                }
            }
            foreach ($dayData as $key => $value) {
                $info['day'][$type[$value->type]]['detail'][] = [
                'time' => $value->days,
                'frequency' => $value->frequency,
                ];                
/*                $info['day'][$type[$value->type]]['detail'][]['time'] = $value->days;
                $info['day'][$type[$value->type]]['detail'][]['frequency'] = $value->frequency;*/
                foreach ($dayCount as $k => $v) {
                    if ($value->type == $v->type) {
                        $info['day'][$type[$value->type]]['count'] = $v->frequency;
                    }
                }
            }
            $nowWeek = date('W');
            foreach ($weekData as $key => $value) {
                $info['week'][$type[$value->type]]['detail'][] = [
                'time' => 4 - ($nowWeek - $value->days),
                'frequency' => $value->frequency,
                ];                       
/*                $info['week'][$type[$value->type]]['detail'][]['time'] = $value->days;
                $info['week'][$type[$value->type]]['detail'][]['frequency'] = $value->frequency;*/
                foreach ($weekCount as $k => $v) {
                    if ($value->type == $v->type) {
                        $info['week'][$type[$value->type]]['count'] = $v->frequency;
                    }
                }
            }
            foreach ($yearData as $key => $value) {
                $info['year'][$type[$value->type]]['detail'][] = [
                'time' => $value->days,
                'frequency' => $value->frequency,
                ];                            
/*                $info['year'][$type[$value->type]]['detail']['time'] = $value->days;
                $info['year'][$type[$value->type]]['detail']['frequency'] = $value->frequency;*/
                foreach ($yearCount as $k => $v) {
                    if ($value->type == $v->type) {
                        $info['year'][$type[$value->type]]['count'] = $v->frequency;
                    }
                } 
            }

            $defaultArr =  [
                'sensitive' => [
                    'detail' => [],
                    'count' => 0,
                ], 
                'move' => [
                    'detail' => [],
                    'count' => 0,
                ], 
                'drop' => [
                    'detail' => [],
                    'count' => 0,
                ], 
                'off' => [
                    'detail' => [],
                    'count' => 0,
                ], 
            ];
            empty($info['hour']) && $info['hour'] = $defaultArr;
            empty($info['day']) && $info['day'] =  $defaultArr;
            empty($info['week']) && $info['week'] = $defaultArr;
            empty($info['year']) && $info['year'] = $defaultArr;
            $retval['status'] = 0;
            $retval['msg'] = $info;
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }


public function getDeviceInfoAndroid(Request $request, User $user) {
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
/*
            $token  = 3;
            $deviceName  = 'F2:D4:B8:46:11:E4';*/

            $time = $_SERVER['REQUEST_TIME'];
            $dayTime = $time - 90 * 24 * 60 * 60;
            $dayData = DB::table('bzk_device_info_log')
                    ->select(DB::raw("from_unixtime(createTime, '%m%d') as days, count(*) as frequency"))
                    ->where('userId', $token)
                    ->where('createTime', '>', $dayTime)
                    ->where('deviceName', $deviceName)
                    ->where('type', 1)
                    ->groupBy('days')
                    ->get();

             $info  = [];
             foreach ($dayData as $key => $value) {
                       $info[$value->days] =  [
                            'days' => $value->days,
                            'frequency' => $value->frequency,
                     ];   
             }      


             for ($i = 0; $i <= 90; $i++) { 
                $day = date('md', $time - $i * 60 * 60 * 24);
                if (!isset($info[$day])) {
                     $noDataDay = [
                            'days' => $day,
                            'frequency' => 0,
                     ];        
                      $info[$day] = $noDataDay;            
                }
             }
             krsort($info);
            $retval['status'] = 0;
            $retval['msg'] = array_values($info);
            echo json_encode($retval);exit;
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }



    public function getDeviceInfoFreAndroid(Request $request, User $user) {
        $token = $request->input('userToken');
        $token = checkToken($token);
        $deviceName = $request->input('deviceName');
        $dateType = $request->input('dateType');
        $dateTime = ($request->input('dateTime') != null && !empty($request->input('dateTime'))) ? $request->input('dateTime') :  $_SERVER['REQUEST_TIME'];


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

/*            $token  = 3;
            $deviceName  = 'F2:D4:B8:46:11:E4';*/
            $timeBegin = strtotime(date("Y-m-d", $dateTime));
            $timeEnd = $timeBegin + 24*60*60-1;

            $dayCount = DB::table('bzk_device_info_log')
                ->where('userId', $token)
                ->where('createTime', '>', $timeBegin)
                ->where('createTime', '<', $timeEnd)
                ->where('deviceName', $deviceName)
                ->where('type', 1)
                ->get();

                $info = [];
             foreach ($dayCount as $key => $value) {
                       $info[] =  [
                            'num' => $key,
                            'time' => $value->disconnect,
                     ];   
             }      
            $retval['status'] = 0;
            $retval['msg'] = array_values($info);
 
            return response()->json($retval);
        } catch (QueryException $e) {
            $retval['status'] = -3;
            $retval['msg'] = $e->getMessage();
            return response()->json($retval);
        }
    }

}
