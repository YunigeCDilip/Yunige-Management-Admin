<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SDataDetailResource extends JsonResource
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
            "id"                            => $this->id,
            "name"                          => $this->name,
            "airtable_id"                   => $this->airtable_id,
            "serial"                        => $this->serial,
            "case_number"                   => $this->case_number,
            "amazon_sold"                   => $this->amazon_sold,
            "by_country"                    => $this->by_country,
            "case_in_charge"                => $this->case_in_charge,
            "categories"                    => json_decode($this->categories, true),
            "memo"                          => $this->memo,
            "matter_date"                   => $this->matter_date,
            "priority"                      => $this->priority,
            "priority_change_date"          => $this->priority_change_date,
            "ingredient_progress"           => $this->ingredient_progress,
            "ingredient_date"               => $this->ingredient_date,
            "ingredient_number_ok"          => $this->ingredient_number_ok,
            "total_ingredient"              => $this->total_ingredient,
            "notification_progress"         => $this->notification_progress,
            "application_date"              => $this->application_date,
            "foreign_noti"                  => $this->foreign_noti,
            "manufact_sales_noti"           => $this->manufact_sales_noti,
            "change_noti"                   => $this->change_noti,
            "sample_progress"               => $this->sample_progress,
            "sample_date"                   => $this->sample_date,
            "sample_tracking_no"            => $this->sample_tracking_no,
            "tracking_url"                  => $this->tracking_url,
            "label_creation_progress"       => $this->label_creation_progress,
            "label_creation_date"           => $this->label_creation_date,
            "no_label_design"               => $this->no_label_design,
            "data_confirmation"             => $this->data_confirmation,
            "data_creation_date"            => $this->data_creation_date,
            "customer_service"              => $this->customer_service,
            "corresponding_date"            => $this->corresponding_date,
            "printing_progress"             => $this->printing_progress,
            "print_date"                    => $this->print_date,
            "delivery_category"             => $this->delivery_category,
            "label_delivery_date"           => $this->label_delivery_date,
            "ingredient_billing_completed"  => $this->ingredient_billing_completed,
            "application_completed"         => $this->application_completed,
            "label_design_completed"        => $this->label_design_completed,
            "ingredient_billing_date"       => $this->ingredient_billing_date,
            "application_completed_date"    => $this->application_completed_date,
            "label_completed_date"          => $this->label_completed_date,
            "analysis_amount"               => $this->analysis_amount,
            "other_billed"                  => $this->other_billed,
            "other_billed_date"             => $this->other_billed_date,
            "all_completed_billing"         => $this->all_completed_billing,
            "all_completed_date"            => $this->all_completed_date,
            "amazon_progress_id"            => $this->amazon_progress_id,
            "created_serial_no"             => $this->created_serial_no,
            "revised_label"                 => $this->revised_label,
            "billing_competed_kurohara"     => $this->billing_competed_kurohara,
            "amazon_quote"                  => $this->amazon_quote,
            "declatation_number"            => $this->declatation_number,
            "product_master"                => $this->product_master,
            "label_requester"               => $this->label_requester,
            "double_checker"                => $this->double_checker,
            "double_checked"                => $this->double_checked,
            "ingredient_costs"              => $this->ingredient_costs,
            "foreign_noti_fee"              => $this->foreign_noti_fee,
            "manufact_sales_noti_fee"       => $this->manufact_sales_noti_fee,
            "change_noti_fee"               => $this->change_noti_fee,
            "label_design_fee"              => $this->label_design_fee,
            "print_components"              => $this->print_components,
            "stamp_print_murata"            => $this->stamp_print_murata,
            "stamp_print_sugio"             => $this->stamp_print_sugio,
            "labeling_priority"             => $this->labeling_priority,
            "calculation"                   => $this->calculation,
            "ingredient_request_takeda"     => $this->ingredient_request_takeda,
            "product_master_request"        => $this->product_master_request,
            "count_product_masters"         => $this->count_product_masters,
            "ingredient_special_note"       => $this->ingredient_special_note,
            "ingredient_transmission"       => $this->ingredient_transmission,
            "transmission_international"    => $this->transmission_international,
            "transmission_national"         => $this->transmission_national,
            "takeda_email"                  => $this->takeda_email,
            "kanban_printed"                => $this->kanban_printed,
            "storage_link"                  => $this->storage_link,
            "test_link"                     => $this->test_link,
            "label_requester_id"            => $this->label_requester_id,
            "supplementary_memo"            => $this->supplementary_memo,
            "send_label_creation"           => $this->send_label_creation,
            "label_creation_request"        => $this->label_creation_request,
            "email"                         => $this->email,
            "delivery"                      => $this->delivery,
            "label_requester"               => $this->labelRequester,
            "incharge"                      => $this->incharge,
            "samples"                       => WdataRelationData::collection($this->whenLoaded('samples')),
            "amazon_progress"               => new AmazonProgressResource($this->whenLoaded('amazonProgress')),
            'attachments'                   => ($attachments) ? $attachments : null,
            'items'                         => ItemMasterRelationResource::collection($this->whenLoaded('items'))
        ];
    }
}
