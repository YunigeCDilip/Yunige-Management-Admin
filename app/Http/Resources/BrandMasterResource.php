<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cData = null;
        $country = $this->whenLoaded('country');
        if(!is_null($country)){
            $cData['id'] = $country->id; 
            $cData['name'] = $country->name; 
        }
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'country'   => $cData
        ];
    }
}
