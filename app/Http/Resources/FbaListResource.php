<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FbaListResource extends JsonResource
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
            'id'        => $this->id,
            'fba_name' => $this->fba_name,
            'notes'      => $this->notes,
            'label'       => $this->label,
            'address' => $this->address,
            
        ];
    }
}
