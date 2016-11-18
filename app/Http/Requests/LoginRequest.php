<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
        return [
            'userName' => 'required|regex:/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/',
            'password' => 'required|max:20|min:6',
            'captcha' => "required|max:5|min:5",
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(){
        return [
            'userName.required' => '用户名不能为空',
            'userName.regex'  => '邮箱格式不正确',
            'password.required'  => '密码不能为空',
            'password.max'  => '密码为6-20位',
            'password.min'  => '密码为6-20位',
            'captcha.required'  => '验证码不能为空',
            'captcha.max'  => '验证码为5位',
            'captcha.min'  => '验证码为5位',
        ];
    }
}
