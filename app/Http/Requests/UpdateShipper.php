<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateShipper extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'shipper_name' => ['required', Rule::unique('shippers', 'shipper_name')->ignore(request('shipper'))]
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
