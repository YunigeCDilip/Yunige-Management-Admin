<?php

namespace App\Http\Resources;

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
        return [
            'id'                    => @$this['id'],
            'Name'                  => @$this['fields']['Name'],
            'country'               => @$this['fields']['country'],
            'clientName'            => @$this['fields']['clientName'],
            'cat'                   => @$this['fields']['cat'],
            'number'                => @$this['fields']['number'],
            'carrier'               => @$this['fields']['carrier'],
            'permitNo'              => @$this['fields']['permitNo'],
            'job'                   => @$this['fields']['job'],
            'pickupDate'            => @$this['fields']['pickupDate'],
            'pickup'                => @$this['fields']['pickup'],
            'freeTime'              => @$this['fields']['freeTime'],
            'memoInvoice'           => @$this['fields']['memoInvoice'],
            'deliveryPlace'         => @$this['fields']['deliveryPlace'],
            'deliveryDate'          => @$this['fields']['deliveryDate'],
            'pickupDatePossible'    => @$this['fields']['pickupDatePossible'],
            'nakamichiFinish'       => @$this['fields']['nakamichiFinish'],
            'inboundStatus'         => @$this['fields']['inboundStatus'],
            'warehouseFinish'       => @$this['fields']['warehouseFinish'],
            'etd'                   => @$this['fields']['etd'],
            'totalWarehouse'        => @$this['fields']['totalWarehouse'],
            'jobType'               => @$this['fields']['jobType'],
            'category'              => @$this['fields']['category'],
            'trkNo'                 => @$this['fields']['trkNo'],
            'deliver'               => @$this['fields']['deliver'],
            'status'                => @$this['fields']['status'],
            'createdTime'           => @$this['createdTime']
        ];
    }
}
