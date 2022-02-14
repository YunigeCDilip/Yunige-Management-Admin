<?php

namespace App\Http\Requests;

class CreateRoleRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ];
    }
}
