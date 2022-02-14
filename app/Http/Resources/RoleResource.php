<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'permissions'       => $this->permissions,
            'created_at'        => strtotime($this->created_at),
            'updated_at'        => strtotime($this->updated_at),
        ];
    }
}
