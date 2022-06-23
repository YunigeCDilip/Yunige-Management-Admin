<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemMasterStoreResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->item->product_name,
            'barcode'   => $this->item->product_barcode,
            'quantity'  => $this->quantity,
            'images'    => ItemImageResource::collection($this->item->images),
        ];
    }
}
