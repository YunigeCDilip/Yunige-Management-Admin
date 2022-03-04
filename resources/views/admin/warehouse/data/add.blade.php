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
                    <label for="client">{{__('messages.client')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="client[]">
                        <option value="">{{__('messages.select_client')}}</option>
                        @forelse(@$clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="trkNo">{{__('messages.track_no')}} <span class="text-danger">*</span></label>
                    <input type="text" name="trkNo" class="form-control" placeholder="e.g : 514120049473">
                    <div class="invalid-feedback" id="trkNo_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="permitNo">{{__('messages.permit_no')}} <span class="text-danger">*</span></label>
                    <input type="text" name="permitNo" class="form-control" placeholder="e.g : 10439678210">
                    <div class="invalid-feedback" id="permitNo_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="carrier">{{__('messages.carrier')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="carrier[]">
                        <option value="">{{__('messages.select_carrier')}}</option>
                        @forelse($carrier as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="carrier_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="memoK">{{__('messages.memok')}} <span class="text-danger">*</span></label>
                    <input type="text" name="memoK" class="form-control" placeholder="e.g : w4065">
                    <div class="invalid-feedback" id="mamoK_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="pic">{{__('messages.pic')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="pic">
                        <option value="">{{__('messages.select_pic')}}</option>
                        @foreach($pic as $value)
                            <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="pic_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="cat">{{__('messages.category')}}<span class="text-danger">*</span></label>
                    <select class="form-control select2" name="cat[]">
                        <option value="">{{__('messages.select_category')}}</option>
                        @foreach($cat as $value)
                            <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="cat_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="status">{{__('messages.status')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="status">
                        <option value="">{{__('messages.select_status')}}</option>
                        @foreach($status as $value)
                            <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">  
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.import_permit')}}</h5>   
                <div class="form-group mb-3 permit-file">
                    <input type="file" name="permit[]" class="dropify permit" data-max-file-size="1M" multiple/>
                    <div class="invalid-feedback" id="permit_error" style="display:none;"></div>
                    <p class="text-muted text-center mt-2 mb-0">{{__('messages.import_permit')}}</p>
                </div>
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.upload_invoice')}}</h5>
                <div class="form-group mb-3 invoice-file">
                    <input type="file" name="invoice[]" class="dropify invoice" data-max-file-size="1M" multiple/>
                    <div class="invalid-feedback" id="invoice_error" style="display:none;"></div>
                    <p class="text-muted text-center mt-2 mb-0">{{__('messages.upload_invoice')}}</p>
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
                <a href="{{route('admin.wdata.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
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
        <!-- Dropzone file uploads-->
        <script src="{{asset('admin')}}/libs/dropzone/dropzone.min.js"></script>
        <script src="{{asset('admin')}}/libs/dropify/dropify.min.js"></script>
        <script src="{{asset('admin/custom/js/warehouse.js')}}"></script>
    @endsection
@endsection