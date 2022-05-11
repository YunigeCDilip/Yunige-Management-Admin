@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.name')}}</h5>
                        <small class="text-muted">
                            {{@$broker->name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.email')}}</h5>
                        <small class="text-muted">
                            {{@$broker->email}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.telephone_no')}}</h5>
                        <small class="text-muted">
                            {{@$broker->telephone_no}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fax_number')}}</h5>
                        <small class="text-muted">
                            {{@$broker->fax_number}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.url')}}</h5>
                        <small class="text-muted">
                            {{@$broker->url}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.url_back')}}</h5>
                        <small class="text-muted">
                            {{@$broker->url_back}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.table_17')}}</h5>
                        <small class="text-muted">
                            {{@$broker->table_70}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.address')}}</h5>
                        <small class="text-muted">
                            {{@$broker->address}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.request_otsunaka')}}</h5>
                        <small class="text-muted">
                            {{@$broker->request_otsunaka}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.data_by_matter')}}</h5>
                        <small class="text-muted">
                            {{@$broker->data_by_matter}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.store_house')}}</h5>
                        <small class="text-muted">
                            {{@$broker->store_house}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.test')}}</h5>
                        <small class="text-muted">
                            {{@$broker->test}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.product_master')}}</h5>
                        <small class="text-muted">
                            {{@$broker->product_master}}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-lg-4">
        <div class="card-box">
            <div class="row">
                <div class="form-group mb-3">
                    <h5>{{__('messages.wdata_3')}}</h5>
                    <small class="text-muted">
                        @forelse($broker->wdatas as $data)
                        <span class="badge badge-primary badge-pill">{{$data->wdata->name}}</span>
                        @empty
                        @endforelse
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
    @endsection
@endsection