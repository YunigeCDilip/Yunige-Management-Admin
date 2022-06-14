@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.name')}}</h5>
                        <small class="text-muted">
                        {{@$outbound->client_name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.client_no')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->serial_number}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.clientjp')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->ja_name}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.clienteng')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->en_name}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.company_tel')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->company_tel}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.shipper')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-pink badge-pill">
                            {{(@$outbound->shipper) ? @$outbound->shipper->shipper_name : ''}}
                            </span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.category')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-primary badge-pill">
                            {{(@$outbound->category) ? @$outbound->category->name : ''}}
                            </span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fax')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->fax}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.hp')}}</h5>
                        <small class="text-muted">
                        {{ @$outbound->hp }}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.warehouse_remarks')}}</h5>
                        <small class="text-muted">
                        {{ @$outbound->warehouse_remarks }}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.invoice_momo')}}</h5>
                        <small class="text-muted">
                        {{ @$outbound->invoice }}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.request_customer_association')}}</h5>
                        <small class="text-muted">
                            @if(@$outbound->requestedClient)
                            <span class="badge badge-warning badge-pill">
                                {{@$outbound->requestedClient->client_name}}
                            </span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.request')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->request}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.customer_classification')}}</h5>
                        <small class="text-muted">
                        {{@$outbound->customer_classification}}
                        </small>
                    </div>                    
                    <div class="form-group mb-3">
                        <h5>{{__('messages.takatsu_working_date')}}</h5>
                        <small class="text-muted">
                        {{(@$outbound->takatsu_working_date) ? @$outbound->takatsu_working_date->format('Y-m-d H:i:s A') : ''}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sugio_book_print')}}</h5>
                        <small class="text-muted">
                            @if(@$outbound->sugio_book_print)
                            <span class="badge badge-success badge-pill">True</span>
                            @else
                            <span class="badge badge-danger badge-pill">False</span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.yamazaki_book_print')}}</h5>
                        <small class="text-muted">
                            @if(@$outbound->yamazaki_book_print)
                            <span class="badge badge-success badge-pill">True</span>
                            @else
                            <span class="badge badge-danger badge-pill">False</span>
                            @endif
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