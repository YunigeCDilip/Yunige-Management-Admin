@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
    <link href="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')

<form id="addForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <div class="form-group mb-3">
                <label for="client">{{__('messages.client')}}</label>
                <select class="form-control select2" name="client">
                    <option value="">{{__('messages.select_client')}}</option>
                    @forelse($clients as $client)
                        <option value="{{$client->id}}">{{$client->client_name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="client_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="resp_per">{{__('messages.resp_per')}}</label>
                <select class="form-control select2" name="user">
                    <option value="">{{__('messages.select_user')}}</option>
                    @forelse($users as $u)
                        <option value="{{$u->id}}">{{$u->name}}</option>
                        @empty
                    @endforelse
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="status">{{__('messages.status')}}</label>
                <select class="form-control select2" name="status">
                    <option value="">{{__('messages.select_status')}}</option>
                    <option value="Email">Email</option>
                    <option value="Reply">Reply</option>
                    <option value="IngredientsCheck">IngredientsCheck</option>
                    <option value="QuotationCalculate">QuotationCalculate</option>
                    <option value="SentQuotation">SentQuotation</option>
                    <option value="Payment">Payment</option>
                    <option value="Sample">Sample</option>
                    <option value="Shipment">Shipment</option>
                    <option value="FedexLabel">FedexLabel</option>
                    <option value="FedexPickup">FedexPickup</option>
                    <option value="Custom">Custom</option>
                    <option value="Warehouse">Warehouse</option>
                    <option value="FBA">FBA</option>
                    <option value="Invoice">Invoice</option>
                    <option value="Ingredients Translate">Ingredients Translate</option>
                    <option value="Meeting">Meeting</option>
                    <option value="Translation Check">Translation Check</option>
                    <option value="Registration">Registration</option>
                    <option value="1102859484@qq.com>">1102859484@qq.com></option>
                    <option value="la">la</option>
                    <option value="label design">label design</option>
                </select>
                <div class="invalid-feedback" id="status_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="pickup">{{__('messages.pickup')}}</label>
                <select class="form-control select2" name="pickup">
                    <option value="">{{__('messages.select_pickup')}}</option>
                    <option value="Fedex">Fedex</option>
                    <option value="Yamato">Yamato</option>
                    <option value="SellerShipment">SellerShipment</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="memo">{{__('messages.memo')}}</label>
                <textarea name="memo" class="form-control"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="translation">{{__('messages.translation')}}</label>
                <input type="text" name="translation" class="form-control" placeholder="">
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card-box">
            <div class="form-group mb-3">
                <label for="compaign">{{__('messages.compaign')}}</label>
                <select class="form-control select2" name="compaign">
                    <option value="0">{{__('messages.0_%')}}</option>
                    <option value="50">{{__('messages.50_%')}}</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="done">{{__('messages.done')}}</label>
                <select class="form-control select2" name="done">
                    <option value="1">{{__('messages.not_done')}}</option>
                    <option value="0">{{__('messages.done')}}</option>
                </select>
            </div>
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.attachments')}}</h5>   
            <div class="form-group mb-3 attachment-file">
                <input type="file" name="attachment[]" class="dropify attachment" data-max-file-size="1M" multiple/>
                <p class="text-muted text-center mt-2 mb-0">{{__('messages.attachments')}}</p>
            </div>
        </div> <!-- end col-->
    </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-data">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.amazon-progress.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
        <!-- Dropzone file uploads-->
        <script src="{{asset('admin')}}/libs/dropify/dropify.min.js"></script>
       <!-- Select2 js-->
        <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
        <script src="{{asset('admin')}}/libs/datetimepicker/moment.min.js" type="text/javascript"></script>
        <script src="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
        <script src="{{asset('admin/custom/js/amazonprogress.js')}}"></script>
    @endsection
@endsection