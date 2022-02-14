<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param Validator $validator
     *
     * @return Response
     */
    protected function failedValidation(Validator $validator)
    {
        // Get all the errors thrown
        // $errors = implode(",", $validator->messages()->all());

        // Either throw the exception, or return it any other way.
        throw new HttpResponseException(response()->json(['status' => false, 'message'=> $validator->messages()], 422));
    }
}
