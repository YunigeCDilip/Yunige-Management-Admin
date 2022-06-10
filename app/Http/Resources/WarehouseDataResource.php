<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return  array
     */
    public function toArray($request)
    {
        $jobs = ($this->jobs) ? $this->jobs->pluck('job.name')->toArray() : null;
        $categories = ($this->jobs) ? $this->jobs->pluck('job.name')->toArray() : null;
        return [
            'id'                    => $this->id,
            'airtable_id'           => $this->airtable_id,
            'Name'                  => $this->name,
            'country'               => ($this->clients) ? (($this->clients->client->shipper) ? $this->clients->client->shipper->shipper_name : null) : null,
            'clientName'            => ($this->clients) ? $this->clients->client->client_name : null,
            'cat'                   => $categories,
            'number'                => $this->warehouse_number,
            'carrier'               => ($this->carrier) ? $this->carrier->name : null,
            'permitNo'              => $this->permit_number,
            'job'                   => $jobs,
            'pickupDate'            => $this->pickup_date,
            'pickup'                => $this->pickup,
            'freeTime'              => $this->free_time,
            'memoInvoice'           => $this->memo_invoice,
            'deliveryPlace'         => ($this->deliveryPlace) ? $this->deliveryPlace->name : null,
            'deliveryDate'          => $this->delivery_date,
            'pickupDatePossible'    => $this->pickup_date_possible,
            'nakamichiFinish'       => ($this->checkBool) ? $this->checkBool->nakamichi_finished : false,
            'inboundStatus'         => ($this->inboundStatus) ? $this->inboundStatus->name : null,
            'warehouseFinish'       => ($this->checkBool) ? $this->checkBool->wfinish : false,
            'etd'                   => null,
            'totalWarehouse'        => null,
            'jobType'               => ($jobs) ? implode(",",$jobs) : null,
            'category'              => ($categories) ? implode(",",$categories) : null,
            'trkNo'                 => $this->track_number,
            'deliver'               => ($this->deliver) ? $this->deliver->name : null,
            'status'                => ($this->status) ? $this->status->name : null,
            'createdTime'           => Carbon::parse($this->created_at)->format('F d, Y')
        ];
    }
}
