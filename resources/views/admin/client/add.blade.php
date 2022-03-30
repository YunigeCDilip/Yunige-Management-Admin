@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<form id="addForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="ja_name">{{__('messages.clientjp')}}</label>
                    <input type="text" name="ja_name" class="form-control">
                    <div class="invalid-feedback" id="ja_name_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="en_name">{{__('messages.clienteng')}}</label>
                    <input type="text" name="en_name" class="form-control">
                    <div class="invalid-feedback" id="en_name_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="shipper">{{__('messages.shipper')}}</label>
                    <select class="form-control select2" name="shipper">
                        <option value="">{{__('messages.select_shipper')}}</option>
                        @forelse($shippers as $shipper)
                            <option value="{{$shipper->id}}">{{$shipper->shipper_name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="shipper_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="sdata">{{__('messages.client_data')}}</label>
                    <select class="form-control select2" name="sdata[]" multiple>
                        <option value="">{{__('messages.select_client_data')}}</option>
                        @forelse($sdatas as $sdata)
                            <option value="{{$sdata->id}}">{{$sdata->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="sdata_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="category">{{__('messages.docs')}}</label>
                    <select class="form-control select2" name="category[]" multiple>
                        <option value="">{{__('messages.select_category')}}</option>
                        @foreach($categories as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="category_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="item">{{__('messages.master_data')}}</label>
                    <select class="form-control select2" name="item[]" multiple>
                        <option value="">{{__('messages.select_master_data')}}</option>
                        @forelse($items as $item)
                            <option value="{{$item->id}}">{{$item->product_name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="item_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="wdata">{{__('messages.warehouse_data')}}</label>
                    <select class="form-control select2" name="wdata[]" multiple>
                        <option value="">{{__('messages.select_warehouse_data')}}</option>
                        @forelse($wdatas as $wdata)
                            <option value="{{$wdata->id}}">{{$wdata->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="wdata_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="amazon">{{__('messages.amazon_progress')}}</label>
                    <select class="form-control select2" name="amazon[]" multiple>
                        <option value="">{{__('messages.select_warehouse_data')}}</option>
                        @forelse($amazons as $amazon)
                            <option value="{{$amazon->id}}">{{$amazon->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="amazon_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="hp">{{__('messages.hp')}}</label>
                    <textarea name="hp" class="form-control"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="request">{{__('messages.request')}}</label>
                    <input type="text" name="request" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="movement">{{__('messages.movement_confirmation')}}</label>
                    <select class="form-control select2" name="movement">
                        <option value="">{{__('messages.select_movement_confirmation')}}</option>
                        @forelse(@$movements as $movement)
                            <option value="{{$movement->id}}">{{$movement->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="client">{{__('messages.request_customer_association')}}</label>
                    <select class="form-control select2" name="client">
                        <option value="">{{__('messages.select_client')}}</option>
                        @forelse(@$clients as $client)
                            <option value="{{$client->id}}">{{$client->client_name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">  
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.contact_detail')}}</h5>   
                <div class="form-group mb-3">
                    <label for="person_name">{{__('messages.resp_per')}}</label>
                    <input type="text" name="person_name" class="form-control" placeholder="e.g : John Doe">
                </div>
        
                <div class="form-group mb-3">
                    <label for="email">{{__('messages.email')}}</label>
                    <input type="text" name="email" class="form-control" placeholder="e.g : john.doe@example.com">
                </div>
                <div class="form-group mb-3">
                    <label for="contact_number">{{__('messages.contact_no')}}</label>
                    <input type="text" name="contact_number" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="seller_name">{{__('messages.seller_name')}}</label>
                    <input type="text" name="seller_name" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="seller_add">{{__('messages.seller_add')}}</label>
                    <input type="text" name="seller_add" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="office_add">{{__('messages.office_add')}}</label>
                    <input type="text" name="office_add" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="pic_add">{{__('messages.pick_add')}}</label>
                    <input type="text" name="pic_add" class="form-control" placeholder="">
                </div>
            </div> <!-- end col-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light saveWdata">
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
        <script src="{{asset('admin/custom/js/client.js')}}"></script>
    @endsection
@endsection