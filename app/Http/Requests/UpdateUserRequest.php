<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateUserRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        $rule = [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore(request('user')),
            ],
            'role' => 'required',
            'permissions' => 'required',
            'status' => 'required',
        ];

        if(request()->has('password')){
            $rule['password'] = 'required';
            $rule['confirm_password'] = 'required|same:password';
        }

        return $rule;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return  array
     */
    public function messages()
    {
        return [
            'permissions.required' => 'At least one permission is required'
        ];
    }
}
