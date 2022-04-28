@extends('layouts.layout')
@section('additional-css')
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
                <label for="name">{{__('messages.name')}} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="">
                <div class="invalid-feedback" id="name_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="email">{{__('messages.email')}}</label>
                <input type="text" name="email" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="telephone_no">{{__('messages.telephone_no')}}</label>
                <input type="text" name="telephone_no" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="fax_number">{{__('messages.fax_number')}}</label>
                <input type="text" name="fax_number" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="url">{{__('messages.url')}}</label>
                <input type="text" name="url" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="url_back">{{__('messages.url_back')}}</label>
                <input type="text" name="url_back" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="data_by_matter">{{__('messages.data_by_matter')}}</label>
                <textarea name="data_by_matter" class="form-control"></textarea>
            </div>
        </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="store_house">{{__('messages.store_house')}}</label>
                    <input type="text" name="store_house" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="test">{{__('messages.test')}}</label>
                    <input type="text" name="test" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="product_master">{{__('messages.product_master')}}</label>
                    <input type="text" name="product_master" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="table_17">{{__('messages.table_17')}}</label>
                    <input type="text" name="table_17" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="address">{{__('messages.address')}}</label>
                    <input type="text" name="address" class="form-control" placeholder="">
                </div>
                <div class="form-group mb-3">
                    <label for="request_otsunaka">{{__('messages.request_otsunaka')}}</label>
                    <input type="text" name="request_otsunaka" class="form-control" placeholder="">
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
                <a href="{{route('admin.custom-brokers.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
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
        <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
        <script src="{{asset('admin/custom/js/custombroker.js')}}"></script>
    @endsection
@endsection