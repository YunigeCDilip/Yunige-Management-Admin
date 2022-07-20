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

<form id="editForm" method="post"  class="needs-validation" enctype="multipart/form-data" novalidate>

    @csrf
    <input type="hidden" name="id" value="{{$item->id}}">

    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            General Informations
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">

                                    <div class="form-group mb-3">
                                        <label for="client">{{__('messages.client')}}</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">{{__('messages.select_client')}}</option>
                                            @forelse(@$clients as $client)
                                                <option value="{{$client->id}}" @if($client->client_name == $item->jp_name) selected @endif >{{$client->client_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category">{{__('messages.item_categories')}}</label>
                                        <select class="form-control select2" name="category">
                                            <option value="">{{__('messages.select_category')}}</option>
                                            @forelse(@$categories as $category)

                                                <option value="{{$category->id}}" @if($category->id == $item->item_category_id) selected @endif >{{$category->name}}</option>

                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="brand_master_id">{{__('messages.select_brand_master')}}</label>
                                        <select class="form-control select2" name="brand_master_id">
                                            <option value="">{{__('messages.select_brand_master')}}</option>
                                            @forelse(@$brands as $brand)
                                                <option value="{{$brand->id}}" @if($brand->id == $item->item_category_id) selected @endif >{{$brand->name}}</option>

                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="product_nickname">{{__('messages.product_nickname')}}</label>
                                        <input type="text" name="product_nickname" class="form-control" value="{{$item->product_nickname}}">
                                        <div class="invalid-feedback" id="product_nickname_error" style="display:none;"></div>
                                    </div>
                            
                                    <div class="form-group mb-3">
                                        <label for="barcode">{{__('messages.barcode')}}</label>
                                        <input type="text" name="barcode" class="form-control" value="{{$item->barcode}}">
                                        <div class="invalid-feedback" id="barcode_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="product_types">{{__('messages.product_types')}}</label>
                                        <select class="form-control select2" name="product_types">
                                            <option value="">{{__('messages.select_product_type')}}</option>
                                            @forelse(@$productTypes as $type)
                                                <option value="{{$type->id}}" @if($type->id == $item->product_type_id) selected @endif >{{$type->name}}</option>

                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="weight">{{__('messages.weight')}}</label>
                                        <input type="text" name="weight" class="form-control" value="{{$item->weight}}">
                                    </div>

                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.images')}}</h5>   
                                    <div class="form-group mb-3 images-file">
                                        <input type="file" name="images[]" class="dropify images" data-max-file-size="1M" multiple/>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.images')}}</p>
                                    </div>
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.pse_docs')}}</h5>   
                                    <div class="form-group mb-3 pdf-file">
                                        <input type="file" name="pdf[]" class="dropify images" data-max-file-size="1M" multiple/>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.pse_docs')}}</p>
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