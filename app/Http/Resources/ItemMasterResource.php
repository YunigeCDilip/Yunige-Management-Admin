<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return  array
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'product_name'              => $this->product_name,
            'product_barcode'           => $this->product_barcode,
            'description'               => $this->description,
            'jp_description'            => $this->jp_description,
            'barcode_entry_date'        => $this->barcode_entry_date,
            'jp_name'                   => $this->jp_name,
            'productgname'              => $this->productgname,
            'gname'                     => $this->gname,
            'product_name_1'            => $this->product_name_1,
            'product_name_2'            => $this->product_name_2,
            'availabity'                => $this->availabity,
            'unit'                      => $this->unit,
            'weight2'                   => $this->weight2,
            'weight'                    => $this->weight,
            'brand'                     => new BrandMasterResource($this->whenLoaded('brands')),
            'category'                  => new ItemCategoryResource($this->whenLoaded('category')),
            'shipper'                   => new ShipperResource($this->whenLoaded('shipper')),
            'label'                     => new ItemLabelResource($this->whenLoaded('label')),
            'client'                    => new RelationClientResource($this->whenLoaded('clientItems')),
            'product_types'             => ProductTypeResource::collection($this->whenLoaded('productTypes')),
            'images'                    => ItemImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
