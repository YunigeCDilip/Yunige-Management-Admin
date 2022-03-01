<?php

namespace App\Http\Requests;

class CreateUserRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'role' => 'required',
            'permissions' => 'required',
            'status' => 'required',
        ];
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
