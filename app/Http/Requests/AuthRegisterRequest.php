<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Config;

/**
 * 账户注册请求参数验证
 */
class AuthRegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = [
            'mobile' => 'required',
            'password' => 'sometimes|required|between:6,20',
            'validateCode' => 'required',
        ];
        return $return;
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号码未填写',
            'password.required' => '密码未填写',
            'password.between' => '密码长度不符合要求',
            'validateCode.required' => '验证码未填写',
        ];
    }

    public function response(array $errors)
    {
        $api_response['status'] = -1;
        $api_response['msg'] = array_values($errors)[0];
        return response()->json($api_response);
    }
}
