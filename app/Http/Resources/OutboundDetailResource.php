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
        $attachments = $this->groupedAttachments();
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'warehouse_in_charge'       => $this->warehouse_in_charge,
            'ship_date'                 => $this->ship_date,
            'create_date'               => $this->create_date,
            'estimited_ship_date'       => $this->estimited_ship_date,
            'invoice_no'                => $this->invoice_no,
            'fba_no'                    => $this->fba_no,
            'po_no'                     => $this->po_no,
            'reserve'                   => $this->reserve,
            'completed'                 => $this->completed,
            'special_notes'             => $this->special_notes,
            'fba_reservation_no'        => $this->fba_reservation_no,
            'fba_entry_date'            => $this->fba_entry_date,
            'small_no'                  => $this->small_no,
            'send_email'                => $this->send_email,
            'wait_date_create_modify'   => $this->wait_date_create_modify,
            'inter_assist_share'        => $this->inter_assist_share,
            'additional_invoice_no'     => $this->additional_invoice_no,
            'url_delivery'              => $this->url_delivery,
            'shipping_company'          => ($this->delivery_id != '') ? $this->delivery->name : null,
            'mail_text'                 => $this->mail_text,
            'wdata_link'                => ($this->wdata) ? $this->wdata->name : null,
            'fbalists'                  => $this->fbalists,
            'attachments'               => (!$attachments->isEmpty()) ? $attachments : null,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
