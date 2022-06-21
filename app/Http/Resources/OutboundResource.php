<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OutboundResource extends JsonResource
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
            'fba_entry_date'            => $this->fba_entry_date,
            'reserve'                   => $this->reserve,
            'shipping_company'          => ($this->delivery_id != '') ? $this->delivery->name : null,
            'additional_invoice_no'     => $this->additional_invoice_no,
            'wdata_link'                => ($this->wdata) ? $this->wdata->name : null,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
