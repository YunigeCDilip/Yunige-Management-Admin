<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OutboundDetailResource extends JsonResource
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
            'id'                        => $this->id,
            'name'                      => $this->name,
            'ship_date'                 => $this->ship_date,
            'create_date'               => $this->create_date,
            'estimited_ship_date'       => $this->estimited_ship_date,
            'invoice_no'                => $this->invoice_no,
            'fba_no'                    => $this->fba_no,
            'po_no'                     => $this->po_no,
            'reserve'                   => $this->reserve,
            'completed'                 => $this->completed,
            'special_notes'             => $this->special_notes,
            'fba_entry_date'            => $this->fba_entry_date,
            'additional_invoice_no'     => $this->additional_invoice_no,
            'fbalists'                  => $this->fbalists,
            'wdata'                     => $this->wdata,
            'delivery'                  => $this->delivery,
            'attachments'               => $this->groupedAttachments(),
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
