<?php

namespace App\Http\Requests;

class UpdateWarehouseData extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'status'    => 'required',
            'client'    => 'required',
            'trkNo'     => 'required',
            'pic'       => 'required',
            'carrier'   => 'required',
            'permitNo'  => 'required',
            'cat'       => 'required'
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
