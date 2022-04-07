@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" /> 
    <link href="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" /> 
    <style>
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
<form id="editForm" method="post" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="client_id" value="{{$client->id}}">
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            General Informations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Contact Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#related" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Related Data
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#others" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Others
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="ja_name">{{__('messages.clientjp')}}</label>
                                        <input type="text" name="ja_name" class="form-control" value="{{$client->ja_name}}">
                                        <div class="invalid-feedback" id="ja_name_error" style="display:none;"></div>
                                    </div>
                            
                                    <div class="form-group mb-3">
                                        <label for="en_name">{{__('messages.clienteng')}}</label>
                                        <input type="text" name="en_name" class="form-control" value="{{$client->en_name}}">
                                        <div class="invalid-feedback" id="en_name_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="company_tel">{{__('messages.company_tel')}}</label>
                                        <input type="text" name="company_tel" class="form-control" placeholder="" value="{{$client->company_tel}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="fax">{{__('messages.fax')}}</label>
                                        <input type="text" name="fax" class="form-control" placeholder="" value="{{$client->fax}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hp">{{__('messages.hp')}}</label>
                                        <textarea name="hp" class="form-control">{{ $client->hp }}</textarea>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="movement">{{__('messages.movement_confirmation')}}</label>
                                        <select class="form-control select2" name="movement">
                                            <option value="">{{__('messages.select_movement_confirmation')}}</option>
                                            @forelse(@$movements as $movement)
                                                <option value="{{$movement->id}}" @if($client->movement_confirmation_id == $movement->id) selected @endif>{{$movement->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="client">{{__('messages.request_customer_association')}}</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">{{__('messages.select_client')}}</option>
                                            @forelse(@$clients as $c)
                                                <option value="{{$c->id}}" @if($client->request_client_id == $c->id) selected @endif>{{$client->client_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="shipper">{{__('messages.shipper')}}</label>
                                        <select class="form-control select2" name="shipper">
                                            <option value="">{{__('messages.select_shipper')}}</option>
                                            @forelse($shippers as $shipper)
                                                <option value="{{$shipper->id}}" @if($shipper->id == $client->shipper_id) selected @endif>{{$shipper->shipper_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="shipper_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="request_data">{{__('messages.request')}}</label>
                                        <input type="text" name="request_data" class="form-control" value="{{$client->request}}">
                                    </div>
                                </div> <!-- end col-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="contact">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">  
                                    <div class="form-group mb-3">
                                        <label for="person_name">{{__('messages.resp_per')}}</label>
                                        <input type="text" name="person_name" class="form-control" placeholder="e.g : John Doe" value="{{$client->contact->name}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact_number">{{__('messages.contact_no')}}</label>
                                        <input type="text" name="contact_number" class="form-control" placeholder="" value="{{$client->contact->contact_number}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="seller_add">{{__('messages.seller_add')}}</label>
                                        <input type="text" name="seller_add" class="form-control" placeholder="" value="{{$client->contact->seller_add}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="office_add">{{__('messages.office_add')}}</label>
                                        <input type="text" name="office_add" class="form-control" placeholder="" value="{{$client->contact->office_add}}">
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="email">{{__('messages.email')}}</label>
                                        <input type="text" name="email" class="form-control" placeholder="e.g : john.doe@example.com" value="{{$client->contact->email}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="seller_name">{{__('messages.seller_name')}}</label>
                                        <input type="text" name="seller_name" class="form-control" placeholder="" value="{{$client->contact->seller_name}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="pic_add">{{__('messages.pick_add')}}</label>
                                        <input type="text" name="pic_add" class="form-control" placeholder="" value="{{$client->contact->pic_add}}">
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="related">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="sdata">{{__('messages.client_data')}}</label>
                                        <select class="form-control select2" name="sdata[]" multiple>
                                            @forelse($sdatas as $sdata)
                                                <option value="{{$sdata->id}}" @if(in_array($sdata->id, $client->sdatas->pluck('sdata_id')->toArray())) selected @endif>{{$sdata->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="sdata_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category">{{__('messages.docs')}}</label>
                                        <select class="form-control select2" name="category">
                                            <option value="">{{__('messages.select_docs')}}</option>
                                            @foreach($categories as $value)
                                                <option value="{{$value->id}}" @if($value->id == $client->client_category_id) selected @endif>{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="category_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="item">{{__('messages.master_data')}}</label>
                                        <select class="form-control select2" name="item[]" multiple>
                                            @forelse($items as $item)
                                                <option value="{{$item->id}}" @if(in_array($item->id, $client->items->pluck('item_master_id')->toArray())) selected @endif>{{$item->product_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="item_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="wdata">{{__('messages.warehouse_data')}}</label>
                                        <select class="form-control select2" name="wdata[]" multiple>
                                            @forelse($wdatas as $wdata)
                                                <option value="{{$wdata->id}}" @if(in_array($wdata->id, $client->wdatas->pluck('wdata_id')->toArray())) selected @endif>{{$wdata->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="wdata_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="amazon">{{__('messages.amazon_progress')}}</label>
                                        <select class="form-control select2" name="amazon[]" multiple>
                                            @forelse($amazons as $amazon)
                                                <option value="{{$amazon->id}}" @if(in_array($amazon->id, $client->amazonProgress->pluck('amazon_progress_id')->toArray())) selected @endif>{{$amazon->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="amazon_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="delivery_classification">{{__('messages.delivery_classification')}}</label>
                                        <select class="form-control select2" name="delivery_classification">
                                            <option value="">{{__('messages.select_delivery_classification')}}</option>
                                            @forelse($classifications as $c)
                                                <option value="{{$c->id}}" @if($c->id == $client->foreign_delivery_classifications_id) selected @endif>{{$c->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="others">
                    <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="customer_classification">{{__('messages.customer_classification')}}</label>
                                        <input type="text" name="customer_classification" class="form-control" placeholder="" value="{{$client->customer_classification}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="takatsu_working_date">{{__('messages.takatsu_working_date')}}</label>
                                        <input type="text" name="takatsu_working_date" class="form-control" placeholder="" value="{{($client->takatsu_working_date) ? $client->takatsu_working_date->format('Y-m-d H:i:s A') : ''}}" id="datetimepicker1">
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch" name="sugio_book_print" value="1" @if($client->sugio_book_print) checked @endif>
                                            <label class="custom-control-label" for="customSwitch">{{__('messages.sugio_book_print')}}</label>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="yamazaki_book_print" value="1" @if($client->yamazaki_book_print) checked @endif>
                                            <label class="custom-control-label" for="customSwitch1">{{__('messages.yamazaki_book_print')}}</label>
                                        </div>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="warehouse_remarks">{{__('messages.warehouse_remarks')}}</label>
                                        <textarea name="warehouse_remarks" class="form-control">{{$client->warehouse_remarks}}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="invoice_momo">{{__('messages.invoice_momo')}}</label>
                                        <textarea name="invoice_momo" class="form-control">{{$client->invoice}}</textarea>
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light update-client">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.clients.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
       <!-- Select2 js-->
        <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
        <script src="{{asset('admin')}}/libs/datetimepicker/moment.min.js" type="text/javascript"></script>
        <script src="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="{{asset('admin/custom/js/client.js')}}"></script>
    @endsection
@endsection