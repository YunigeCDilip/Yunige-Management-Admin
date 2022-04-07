<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateMovementConfirmation extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('movement_confirmations', 'name')->ignore(request('movement'))]
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
