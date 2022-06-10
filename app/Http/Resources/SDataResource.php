<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SDataResource extends JsonResource
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
            'id'   => $this->id,
            'name'   => $this->name,
            'case_number'   => $this->case_number,
            'country'   => $this->by_country,
            'case_in_charge'   => $this->case_in_charge,
            'memo'   => $this->memo,
            'matter_date'   => $this->matter_date,
            'priority'   => $this->priority,
            'priority_change_date'   => $this->priority_change_date,
            'ingredient_progress'   => $this->ingredient_progress,
            'ingredient_date'   => $this->ingredient_date,
            'notification_progress'   => $this->notification_progress,
            'application_date'   => $this->application_date,
            'sample_progress'   => $this->sample_progress,
            'sample_date'   => $this->sample_date,
            'delivery_id'   => $this->delivery_id,
            'label_creation_progress'   => $this->label_creation_progress,
            'label_creation_date'   => $this->label_creation_date,
            'data_confirmation'   => $this->data_confirmation,
            'data_creation_date'   => $this->data_creation_date
        ];
    }
}
