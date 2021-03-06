<?php

namespace App\Http\Requests;

class CheckBarcodeRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'barcode' => 'required'
        ];
    }
}
