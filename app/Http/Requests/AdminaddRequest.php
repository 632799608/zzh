<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminaddRequest extends Request
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
        $rules = [];
        if($this->isMethod('post')){
            $rules = [
            'userName' => 'required|unique:users,name|max:16|min:4',
            'password' => 'required',
            'password2' => 'required|same:password',
            'email' => "required",
            'userRole'=>"required"
            ];
        }
        return $rules;
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(){
        return [
            'userName.required' => '用户名不能为空',
            'userName.max'  => '用户名为4-16字符',
            'userName.min'  => '用户名为4-16字符',
            'userName.unique'  => '该用户已存在',
            'password.required'  => '密码不能为空',
            'password2.same'  => '两次密码不一致',
            'email.required'  => '邮箱不能为空',
            'email.email'  => '邮箱格式错误',
            'userRole.required'  => '角色不能为空',
        ];
    }
}
