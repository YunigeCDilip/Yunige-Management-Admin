<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateDeliverRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('delivers', 'name')->ignore(request('deliver'))]
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
