<?php

namespace App\Http\Requests;

class CreateWarehouseData extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        $trasnport = ['sea','air'];
        return [
            'project_charge'   => 'required|exists:users,id',
            'transport'    => 'required|in:'.implode(',', $trasnport),
            'incoterms'    => 'required',
            'category'     => 'required',
            'client'       => 'required|exists:clients,id',
            'arrival_place'    => 'required',
            'document_case'   => 'required',
            'arrival_progress'  => 'required',
            'goods_progress'     => 'required',
            'items.*.product' => 'required|exists:item_masters,id',
            'items.*.labeling_status' => 'required',
            'items.*.warehouse_qty' => 'required|numeric',
            'items.*.fnsku_not_req' => 'required',
            'items.*.reg_work_inst' => 'required',
            'items.*.reg_work_inst.*' => 'required',

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
            'items.*.product.required' => 'The product field is required.',
            'items.*.labeling_status.required' => 'The labeling status field is required.',
            'items.*.warehouse_qty.required' => 'The warehouse qty field is required.',
            'items.*.fnsku_not_req.required' => 'The FNSKU field is required.',
            'items.*.reg_work_inst.required' => 'The work instructions field is required.',
        ];
    }
}
