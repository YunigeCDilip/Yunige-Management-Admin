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
                        <h5>{{__('messages.client_name')}}</h5>
                        <small class="text-muted">
                        {{$client->client_name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.client_no')}}</h5>
                        <small class="text-muted">
                            {{$client->serial_number}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.clientjp')}}</h5>
                        <small class="text-muted">
                            {{$client->ja_name}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.clienteng')}}</h5>
                        <small class="text-muted">
                            {{$client->en_name}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.company_tel')}}</h5>
                        <small class="text-muted">
                            {{$client->company_tel}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.shipper')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-pink badge-pill">
                            {{$client->shipper->shipper_name}}
                            </span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.category')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-primary badge-pill">
                            {{$client->category->name}}
                            </span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fax')}}</h5>
                        <small class="text-muted">
                            {{$client->fax}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.hp')}}</h5>
                        <small class="text-muted">
                        {{ $client->hp }}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.warehouse_remarks')}}</h5>
                        <small class="text-muted">
                        {{ $client->warehouse_remarks }}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.invoice_momo')}}</h5>
                        <small class="text-muted">
                        {{ $client->invoice }}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.request_customer_association')}}</h5>
                        <small class="text-muted">
                            @if($client->requestedClient)
                            <span class="badge badge-warning badge-pill">
                                {{$client->requestedClient->client_name}}
                            </span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.request')}}</h5>
                        <small class="text-muted">
                            {{$client->request}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.client_data')}}</h5>
                        <small class="text-muted">
                            @forelse($client->sdatas as $d)
                                <span class="badge badge-dark badge-pill">
                                    {{$d->sdata->name}}
                                </span>
                                @empty
                            @endforelse
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.warehouse_data')}}</h5>
                        @forelse($client->wdatas as $d)
                            <span class="badge badge-light badge-pill">
                                {{$d->wdata->name}}
                            </span>
                            @empty
                        @endforelse
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.master_data')}}</h5>
                        <small class="text-muted">
                            @forelse($client->items as $d)
                                <span class="badge badge-dark badge-pill">
                                    {{$d->item->product_name}}
                                </span>
                                @empty
                            @endforelse
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.amazon_progress')}}</h5>
                        <small class="text-muted">
                            @forelse($client->amazonProgress as $da)
                                <span class="badge badge-blue badge-pill">
                                    {{$da->progress->name}}
                                </span>
                                @empty
                            @endforelse
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.delivery_classification')}}</h5>
                        <small class="text-muted">
                            @if($client->classification)
                            <span class="badge badge-info badge-pill">
                                {{$client->classification->name}}
                            </span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.customer_classification')}}</h5>
                        <small class="text-muted">
                        {{$client->customer_classification}}
                        </small>
                    </div>                    
                    <div class="form-group mb-3">
                        <h5>{{__('messages.takatsu_working_date')}}</h5>
                        <small class="text-muted">
                        {{($client->takatsu_working_date) ? $client->takatsu_working_date->format('Y-m-d H:i:s A') : ''}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sugio_book_print')}}</h5>
                        <small class="text-muted">
                            @if($client->sugio_book_print)
                            <span class="badge badge-success badge-pill">True</span>
                            @else
                            <span class="badge badge-danger badge-pill">False</span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.yamazaki_book_print')}}</h5>
                        <small class="text-muted">
                            @if($client->yamazaki_book_print)
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
    <div class="col-lg-4">
        <div class="card-box">
            <div class="form-group mb-3">
                <h5>{{__('messages.resp_per')}}</h5>
                <small class="text-muted">
                {{$client->contact->name}}
                </small>
            </div>            
            <div class="form-group mb-3">
                <h5>{{__('messages.email')}}</h5>
                <small class="text-muted">
                {{$client->contact->email}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.contact_no')}}</h5>
                <small class="text-muted">
                {{$client->contact->contact_number}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.seller_add')}}</h5>
                <small class="text-muted">
                {{$client->contact->seller_add}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.office_add')}}</h5>
                <small class="text-muted">
                {{$client->contact->office_add}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.seller_name')}}</h5>
                <small class="text-muted">
                {{$client->contact->seller_name}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.pick_add')}}</h5>
                <small class="text-muted">
                {{$client->contact->pic_add}}
                </small>
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