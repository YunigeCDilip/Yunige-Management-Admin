<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateInbounStatus extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('inbound_statuses', 'name')->ignore(request('id'))]
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
