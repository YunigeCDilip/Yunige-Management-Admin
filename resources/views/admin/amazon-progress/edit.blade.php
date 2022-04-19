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

<form id="editForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="amazon_progress_id" value="{{$amazon->id}}">
    <div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <div class="form-group mb-3">
                <label for="client">{{__('messages.client')}}</label>
                <select class="form-control select2" name="client">
                    <option value="">{{__('messages.select_client')}}</option>
                    @forelse($clients as $client)
                        <option value="{{$client->id}}" @if(@$amazon->amazonProgress->client_id == $client->id) selected @endif>{{$client->client_name}}</option>
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
                        <option value="{{$u->id}}" @if(@$amazon->user_id == $u->id) selected @endif>{{$u->name}}</option>
                        @empty
                    @endforelse
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="status">{{__('messages.status')}}</label>
                <select class="form-control select2" name="status">
                    <option value="">{{__('messages.select_status')}}</option>
                    <option value="Email" @if($amazon->status == 'Email') selected @endif>Email</option>
                    <option value="Reply" @if($amazon->status == 'Reply') selected @endif>Reply</option>
                    <option value="IngredientsCheck" @if($amazon->status == 'IngredientsCheck') selected @endif>IngredientsCheck</option>
                    <option value="QuotationCalculate" @if($amazon->status == 'QuotationCalculate') selected @endif>QuotationCalculate</option>
                    <option value="SentQuotation" @if($amazon->status == 'SentQuotation') selected @endif>SentQuotation</option>
                    <option value="Payment" @if($amazon->status == 'Payment') selected @endif>Payment</option>
                    <option value="Sample" @if($amazon->status == 'Sample') selected @endif>Sample</option>
                    <option value="Shipment" @if($amazon->status == 'Shipment') selected @endif>Shipment</option>
                    <option value="FedexLabel" @if($amazon->status == 'FedexLabel') selected @endif>FedexLabel</option>
                    <option value="FedexPickup" @if($amazon->status == 'FedexPickup') selected @endif>FedexPickup</option>
                    <option value="Custom" @if($amazon->status == 'Custom') selected @endif>Custom</option>
                    <option value="Warehouse" @if($amazon->status == 'Warehouse') selected @endif>Warehouse</option>
                    <option value="FBA" @if($amazon->status == 'FBA') selected @endif>FBA</option>
                    <option value="Invoice" @if($amazon->status == 'Invoice') selected @endif>Invoice</option>
                    <option value="Ingredients Translate" @if($amazon->status == 'Ingredients Translate') selected @endif>Ingredients Translate</option>
                    <option value="Meeting" @if($amazon->status == 'Meeting') selected @endif>Meeting</option>
                    <option value="Translation Check" @if($amazon->status == 'Translation Check') selected @endif>Translation Check</option>
                    <option value="Registration" @if($amazon->status == 'Registration') selected @endif>Registration</option>
                    <option value="1102859484@qq.com>" @if($amazon->status == '1102859484@qq.com>') selected @endif>1102859484@qq.com></option>
                    <option value="la" @if($amazon->status == 'la') selected @endif>la</option>
                    <option value="label design" @if($amazon->status == 'label design') selected @endif>label design</option>
                </select>
                <div class="invalid-feedback" id="status_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="pickup">{{__('messages.pickup')}}</label>
                <select class="form-control select2" name="pickup">
                    <option value="">{{__('messages.select_pickup')}}</option>
                    <option value="Fedex" @if($amazon->pickup == 'Fedex') selected @endif>Fedex</option>
                    <option value="Yamato" @if($amazon->pickup == 'Yamato') selected @endif>Yamato</option>
                    <option value="SellerShipment" @if($amazon->pickup == 'SellerShipment') selected @endif>SellerShipment</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="memo">{{__('messages.memo')}}</label>
                <textarea name="memo" class="form-control">{{$amazon->memo}}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="translation">{{__('messages.translation')}}</label>
                <input type="text" name="translation" class="form-control" placeholder="" value="{{$amazon->translation}}">
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card-box">
            <div class="form-group mb-3">
                <label for="compaign">{{__('messages.compaign')}}</label>
                <select class="form-control select2" name="compaign">
                    <option value="0" @if($amazon->champain == '0') selected @endif>{{__('messages.0_%')}}</option>
                    <option value="50" @if($amazon->champain == '50') selected @endif>{{__('messages.50_%')}}</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="done">{{__('messages.done')}}</label>
                <select class="form-control select2" name="done">
                    <option value="0" @if(!$amazon->done) selected @endif>{{__('messages.not_done')}}</option>
                    <option value="1" @if($amazon->done) selected @endif>{{__('messages.done')}}</option>
                </select>
            </div>
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.attachments')}}</h5>   
            <div class="form-group mb-3 attachment-file">
                <input type="file" name="attachment[]" class="dropify attachment" data-max-file-size="1M" multiple/>
                <p class="text-muted text-center mt-2 mb-0">{{__('messages.attachments')}}</p>
            </div>
            @if(!$amazon->files->isEmpty())
            <div class="form-group mb-3">
                <table class="table table-centered table-hover mb-0">
                    <thead>
                        <th>File</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($amazon->files as $file)
                        <tr>
                            <td>
                                <img src="{{$file->url}}" alt="Amazon Progress" height="60">
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-danger form-button mt-0 delete-file" data-id="{{$file->id}}">-</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div> <!-- end col-->
    </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light update-data">
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