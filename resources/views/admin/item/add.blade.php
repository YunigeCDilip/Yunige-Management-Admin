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

<form id="addForm" method="post" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            General Informations
                        </a>
                    </li>
                    <!-- <li class="nav-item">
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
                    </li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="ja_name">{{__('messages.item_jp')}}</label>
                                        <input type="text" name="ja_name" class="form-control">
                                        <div class="invalid-feedback" id="ja_name_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="ja_description">{{__('messages.ja_description')}}</label>
                                        <textarea name="ja_description" class="form-control"></textarea>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="client">{{__('messages.client')}}</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">{{__('messages.select_client')}}</option>
                                            @forelse(@$clients as $client)
                                                <option value="{{$client->id}}">{{$client->client_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                            
                                    <div class="form-group mb-3">
                                        <label for="barcode">{{__('messages.barcode')}}</label>
                                        <input type="text" name="barcode" class="form-control">
                                        <div class="invalid-feedback" id="barcode_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="pproduct_types">{{__('messages.product_types')}}</label>
                                        <select class="form-control select2" name="pproduct_types[]" multiple>
                                            <option value="">{{__('messages.select_product_type')}}</option>
                                            @forelse(@$productTypes as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category">{{__('messages.item_categories')}}</label>
                                        <select class="form-control select2" name="category">
                                            <option value="">{{__('messages.select_category')}}</option>
                                            @forelse(@$categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="unit">{{__('messages.unit')}}</label>
                                        <input type="text" name="unit" class="form-control">
                                        <div class="invalid-feedback" id="unit_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="weight">{{__('messages.weight')}}</label>
                                        <input type="text" name="weight" class="form-control">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="weight2">{{__('messages.weight_2')}}</label>
                                        <input type="text" name="weight2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="en_name">{{__('messages.item_en')}}</label>
                                        <input type="text" name="en_name" class="form-control">
                                        <div class="invalid-feedback" id="en_name_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="en_description">{{__('messages.en_description')}}</label>
                                        <textarea name="en_description" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="barcode_entry_date">{{__('messages.barcode_entry_date')}}</label>
                                        <input type="text" name="barcode_entry_date" class="form-control datetimepicker" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="label">{{__('messages.item_labels')}}</label>
                                        <select class="form-control select2" name="label">
                                            <option value="">{{__('messages.select_label')}}</option>
                                            @forelse(@$labels as $label)
                                                <option value="{{$label->id}}">{{$label->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="brand">{{__('messages.brand_r')}}</label>
                                        <select class="form-control select2" name="brand">
                                            <option value="">{{__('messages.select_brand_master')}}</option>
                                            @forelse(@$brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="shipper">{{__('messages.shipper')}}</label>
                                        <select class="form-control select2" name="shipper">
                                            <option value="">{{__('messages.select_shipper')}}</option>
                                            @forelse(@$shippers as $shipper)
                                                <option value="{{$shipper->id}}">{{$shipper->shipper_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.images')}}</h5>   
                                    <div class="form-group mb-3 images-file">
                                        <input type="file" name="images[]" class="dropify images" data-max-file-size="1M" multiple/>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.images')}}</p>
                                    </div>
                                </div>
                            </div>
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
                <button class="btn w-sm btn-success waves-effect waves-light save-client">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.items.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
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
        <script src="{{asset('admin/custom/js/item.js')}}"></script>
    @endsection
@endsection