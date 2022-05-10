<?php

namespace App\Http\Requests;

class CreateBrandMaster extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'ja_name' => 'required_if:en_name,null',
            'en_name' => 'required_if:ja_name,null',
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
            //  Define custom messages for rules
        ];
    }
}
