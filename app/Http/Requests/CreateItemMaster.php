<?php

namespace App\Http\Requests;

class CreateItemMaster extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'client' => 'required|exists:clients,id',
            'item_category' => 'required|exists:item_categories,id',
            'product_nickname' => 'required',
            'product_barcode' => 'required',
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
