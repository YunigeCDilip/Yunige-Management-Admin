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
            'invoice'   => 'required',
            'status'    => 'required',
            'client'    => 'required',
            'trkNo'     => 'required',
            'pic'       => 'required',
            'permit'    => 'required',
            'carrier'   => 'required',
            'permitNo'  => 'required',
            'memoK'     => 'required',
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
