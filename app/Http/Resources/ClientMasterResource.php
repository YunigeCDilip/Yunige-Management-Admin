<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientMasterResource extends JsonResource
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
            'serial_number' => $this->serial_number,
            'name'      => $this->client_name,
            'airtable_id'       => $this->airtable_id,
            'en_name' => $this->en_name,
            'ja_name'       => $this->ja_name,
            'category_name'       => $this->category_name,
            'shipper_name'       => $this->shipper_name,
            'person_name'       => $this->resp_person,
            'contact'       => $this->contact_number,
            
        ];
    }
}
