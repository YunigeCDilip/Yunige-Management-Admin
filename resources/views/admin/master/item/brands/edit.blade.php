@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')

<form id="editForm" method="post" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="brand_id" value="{{$brand->id}}">
    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
            <div class="form-group mb-3">
                <label for="ja_name">{{__('messages.brandJp')}}</label>
                <input type="text" name="ja_name" class="form-control" value="{{$brand->ja_name}}">
                <div class="invalid-feedback" id="ja_name_error" style="display:none;"></div>
            </div>
    
            <div class="form-group mb-3">
                <label for="en_name">{{__('messages.brandEng')}}</label>
                <input type="text" name="en_name" class="form-control" value="{{$brand->en_name}}">
                <div class="invalid-feedback" id="en_name_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="client">{{__('messages.country')}}</label>
                <select class="form-control select2" name="country">
                    <option value="">{{__('messages.select_country')}}</option>
                    @forelse(@$countries as $client)
                        <option value="{{$client->id}}" @if($client->id == $brand->country_id) selected @endif>{{$client->name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="client_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="category">{{__('messages.category')}}</label>
                <input type="text" name="category" class="form-control" placeholder="" value="{{$brand->category}}">
            </div>
            <div class="form-group mb-3">
                <label for="brand_url">{{__('messages.brand_url')}}</label>
                <input type="text" name="brand_url" class="form-control" placeholder="" value="{{$brand->brand_url}}">
            </div>
            <div class="form-group mb-3">
                <label for="remarks">{{__('messages.remarks')}}</label>
                <textarea name="remarks" class="form-control">{{$brand->remarks}}</textarea>
            </div>
        </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="parallel_import">{{__('messages.parallel_import')}}</label>
                    <select class="form-control select2" name="parallel_import">
                        <option value="1" @if($brand->parallel_import == 1) selected @endif>{{__('messages.true')}}</option>
                        <option value="0" @if($brand->parallel_import == 0) selected @endif>{{__('messages.false')}}</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="check">{{__('messages.check')}}</label>
                    <select class="form-control select2" name="check">
                        <option value="1" @if($brand->check == 1) selected @endif>{{__('messages.true')}}</option>
                        <option value="0" @if($brand->check == 0) selected @endif>{{__('messages.false')}}</option>
                    </select>
                </div>
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.logo')}}</h5>   
                <div class="form-group mb-3 logo-file">
                    <input type="file" name="logo" class="dropify logo_attachment" data-max-file-size="1M"/>
                    <p class="text-muted text-center mt-2 mb-0">{{__('messages.logo')}}</p>
                </div>
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
                <a href="{{route('admin.item-brands.index')}}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
     <script src="{{asset('admin')}}/libs/dropify/dropify.min.js"></script>
       <!-- Select2 js-->
        <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
        <script src="{{asset('admin/custom/js/brandmasters.js')}}"></script>
    @endsection
@endsection