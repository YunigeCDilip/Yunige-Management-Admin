<?php

namespace App\Http\Requests;

class CreateClientCategory extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:client_categories,name'
        ];
    }
}
