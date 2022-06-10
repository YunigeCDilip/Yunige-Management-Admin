<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemMasterRelationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->item->id,
            'product_name'              => $this->item->product_name,
            'product_barcode'           => $this->item->product_barcode,
            'description'               => $this->item->description,
            'barcode_entry_date'        => $this->item->barcode_entry_date
        ];
    }
}
