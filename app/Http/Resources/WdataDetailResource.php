<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WdataDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $jobs = ($this->jobs) ? $this->jobs->pluck('job.name')->toArray() : null;
        $categories = ($this->jobs) ? $this->jobs->pluck('job.name')->toArray() : null;
        return [
            'id'                        => $this->id,
            'airtable_id'               => $this->airtable_id,
            'name'                      => $this->name,
            'country'                   => ($this->clients) ? (($this->clients->client->shipper) ? $this->clients->client->shipper->shipper_name : null) : null,
            'client_id'                 => ($this->clients) ? $this->clients->client_id : null,
            'client_name'               => ($this->clients) ? $this->clients->client->client_name : null,
            'number'                    => $this->warehouse_number,
            'permit_no'                 => $this->permit_number,
            'pickup_date'               => $this->pickup_date,
            'pickup'                    => $this->pickup,
            'free_time'                 => $this->free_time,
            'memo_invoice'              => $this->memo_invoice,
            'delivery_place'            => $this->deliveryPlace,
            'delivery_date'             => $this->delivery_date,
            'pickup_date_possible'      => $this->pickup_date_possible,
            'nakamichi_finish'          => ($this->checkBool) ? $this->checkBool->nakamichi_finished : false,
            'warehouse_finish'          => ($this->checkBool) ? $this->checkBool->wfinish : false,
            'finished'                  => ($this->checkBool) ? $this->checkBool->finished : false,
            'mail_sent'                 => ($this->checkBool) ? $this->checkBool->mail_sent : false,
            'check_finished'            => ($this->checkBool) ? $this->checkBool->check_finished : false,
            'ok'                        => ($this->checkBool) ? $this->checkBool->ok : false,
            'import_permit_check'       => ($this->checkBool) ? $this->checkBool->import_permit_check : false,
            'delete_check'              => ($this->checkBool) ? $this->checkBool->delete_check : false,
            'panel_check'               => ($this->checkBool) ? $this->checkBool->panel_check : false,
            'invoice_list'              => ($this->checkBool) ? $this->checkBool->invoice_list : false,
            'etd'                       => null,
            'total_warehouse'           => null,
            'cat'                       => $categories,
            'job'                       => $jobs,
            'inbound_status'            => $this->inboundStatus,
            'jobType'                   => ($jobs) ? implode(",",$jobs) : null,
            'category'                  => ($categories) ? implode(",",$categories) : null,
            'trkNo'                     => $this->track_number,
            'deliver'                   => $this->deliver,
            'pic'                       => $this->pic,
            'container'                 => $this->container,
            'carrier'                   => $this->carrier,
            'reason'                    => $this->reason,
            'trkInput'                  => $this->trkInput,
            'shipment_method'           => $this->shipmentMethod,
            'warehousepic'              => $this->warehousepic,
            'status'                    => $this->status,
            'incomplete'                => $this->incomplete,
            'transfer'                  => $this->transfer,
            'pick_direction'            => $this->pickDirection,
            'created_time'              => Carbon::parse($this->created_at)->format('F d, Y'),
            'attachments'               => $this->groupedAttachments()
        ];
    }
}
