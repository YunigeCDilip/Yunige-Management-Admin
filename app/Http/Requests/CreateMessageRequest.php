<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class CreateMessageRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules(Request $request)
    {
        if(isset($request['designation']) || isset($request['user'])){
            return [
                'designation' => 'required_if:user,null',
                'user' => 'required_if:designation,null',
                'subject' => 'required'
            ];
        }else{
            return [
                'designation' => 'required',
                'user' => 'required',
                'subject' => 'required'
            ];
        }
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
