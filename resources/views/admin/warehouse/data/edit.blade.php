@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<form id="editForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="wdata_id" value="{{$wdata->id}}">
    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="client">Client <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="client[]" multiple>
                        <option value="">Select</option>
                        @forelse(@$clients as $client)
                            <option value="{{$client->id}}" @if(in_array($client->id, $wdata->fields->client)) selected @endif>{{$client->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="trkNo">Track Number <span class="text-danger">*</span></label>
                    <input type="text" name="trkNo" class="form-control" placeholder="e.g : 514120049473" value="{{@$wdata->fields->trkNo}}">
                    <div class="invalid-feedback" id="trkNo_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="permitNo">Permit Number <span class="text-danger">*</span></label>
                    <input type="text" name="permitNo" class="form-control" placeholder="e.g : 10439678210" value="{{@$wdata->fields->permitNo}}">
                    <div class="invalid-feedback" id="permitNo_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="carrier">Carrier <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="carrier[]" multiple>
                        <option value="">Select</option>
                        @forelse($carrier as $c)
                            <option value="{{$c->id}}" @if(@$wdata->fields->carrier) @if(in_array($c->id, @$wdata->fields->carrier)) selected @endif @endif>{{$c->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="carrier_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="memoK">MemoK <span class="text-danger">*</span></label>
                    <input type="text" name="memoK" class="form-control" placeholder="e.g : w4065" value="{{@$wdata->fields->memoK}}">
                    <div class="invalid-feedback" id="mamoK_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="pic">Pic <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="pic">
                        <option value="">Select</option>
                        @foreach($pic as $value)
                            <option value="{{$value}}" @if($value = @$wdata->fields->pic) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="pic_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="cat">Cat <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="cat[]" multiple>
                        <option value="">Select</option>
                        @foreach($cat as $value)
                            <option value="{{$value}}" @if(@$wdata->fields->cat) @if(in_array($value, @$wdata->fields->cat)) selected @endif @endif>{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="cat_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="status">
                        <option value="">Select</option>
                        @foreach($status as $value)
                            <option value="{{$value}}" @if($value = @$wdata->fields->status) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">  
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Import Permit</h5>   
                <div class="form-group mb-3 permit-file">
                    <input type="file" name="permit[]" class="dropify permit" data-max-file-size="1M" multiple />
                    <div class="invalid-feedback" id="permit_error" style="display:none;"></div>
                    <p class="text-muted text-center mt-2 mb-0">Import Permit</p>
                </div>
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Upload Invoice</h5>
                <div class="form-group mb-3 invoice-file">
                    <input type="file" name="invoice[]" class="dropify invoice" data-max-file-size="1M" multiple />
                    <div class="invalid-feedback" id="invoice_error" style="display:none;"></div>
                    <p class="text-muted text-center mt-2 mb-0">Import Invoice</p>
                </div>
            </div> <!-- end col-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light updateWdata">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    Save
                </button>
                <a href="{{route('admin.wdata.index')}}" class="btn w-sm btn-danger waves-effect">Cancel</a>
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