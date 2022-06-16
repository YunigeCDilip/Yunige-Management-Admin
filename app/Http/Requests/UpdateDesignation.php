<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateDesignation extends ValidationRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('Designations', 'name')->ignore(request('Designation'))]
            
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
