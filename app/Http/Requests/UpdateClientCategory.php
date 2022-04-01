<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateClientCategory extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('client_categories', 'name')->ignore(request('category'))]
        ];
    }
}
