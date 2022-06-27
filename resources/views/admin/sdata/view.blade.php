@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="container">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.name')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.case_number')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->case_number}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.amazon_sold')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->amazon_sold}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.by_country')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->by_country}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.case_in_charge')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->case_in_charge}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.categories')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->categories}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.memo')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->memo}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.matter_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->matter_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.priority')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->priority}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.priority_change_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->priority_change_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_progress')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.total_ingredient')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->total_ingredient}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.notification_progress')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->notification_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.application_date')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->application_date}}
                        </small>
                    </div>                     
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sample_progress')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->sample_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sample_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->sample_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.foreign_noti')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->foreign_noti}}
                        </small>
                    </div>
                    
                </div>
                <div class="col-sm-4">
                    
                    <div class="form-group mb-3">
                        <h5>{{__('messages.manufact_sales_noti')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->manufact_sales_noti}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.change_noti')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->change_noti}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.delivery_id')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->delivery_id}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sample_tracking_no')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->sample_tracking_no}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.tracking_url')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->tracking_url}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_creation_progress')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->label_creation_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_creation_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->label_creation_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.no_label_design')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->no_label_design}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.data_confirmation')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->data_confirmation}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.data_creation_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->data_creation_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.customer_service')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->customer_service}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.corresponding_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->corresponding_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.printing_progress')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->printing_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.delivery_category')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->delivery_category}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_delivery_date')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->label_delivery_date}}
                        </small>
                    </div>                     
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_requester')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->label_requester}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.double_checker')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->double_checker}}
                        </small>
                    </div>
                    
                </div>
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_costs')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_costs}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.foreign_noti_fee')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->foreign_noti_fee}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.manufact_sales_noti_fee')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->manufact_sales_noti_fee}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.change_noti_fee')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->change_noti_fee}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_design_fee')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->label_design_fee}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.labeling_priority')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->labeling_priority}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.calculation')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->calculation}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_request_takeda')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_request_takeda}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.product_master_request')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->product_master_request}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.count_product_masters')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->count_product_masters}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_special_note')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_special_note}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_transmission')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_transmission}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.takeda_email')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->takeda_email}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.storage_link')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->storage_link}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.test_link')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->test_link}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.supplementary_memo')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->supplementary_memo}}
                        </small>
                    </div>                     
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_creation_request')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->label_creation_request}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.email')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->email}}
                        </small>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
    @endsection
@endsection