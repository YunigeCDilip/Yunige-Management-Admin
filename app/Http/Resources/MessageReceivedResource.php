<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageReceivedResource extends JsonResource
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
            'id' => $this->message->id,
            'subject' => $this->message->subject,
            'message' => $this->message->message,
            'draft' => (bool) $this->message->draft,
            'sent' => (bool) $this->message->sent,
            'read' => (bool) $this->read,
            'designation' => ($this->message->designation_id) ? $this->message->designation->name : null,
            'sender' => $this->message->sender,
            'created_at' => $this->message->created_at->diffForHumans(),
        ];
    }
}
