<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'id' => $this->id,
            'subject' => $this->subject,
            'message' => $this->message,
            'draft' => (bool) $this->draft,
            'sent' => (bool) $this->sent,
            'designation' => ($this->designation_id) ? $this->designation : null,
            'sender' => $this->sender,
            'receivers' => $this->users,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
