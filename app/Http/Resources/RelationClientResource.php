<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelationClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $client = $this->whenLoaded('client');
        return [
            'id'                => $client->id,
            'serial_number'     => $client->serial_number,
            'name'              => $client->client_name,
        ];
    }
}
