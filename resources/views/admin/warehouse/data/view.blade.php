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
                        <h5>{{__('messages.warehouse_data')}}{{__('messages.name')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.client')}}{{__('messages.name')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->client_name}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    @if($wdata->pic)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.pic')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-primary badge-pill">{{$wdata->pic->name}}</span>
                        </small>
                    </div>
                    @endif
                    @if($wdata->country)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.country')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-secondary badge-pill">{{$wdata->country}}</span>
                        </small>
                    </div>
                    @endif
                    @if($wdata->category)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.category')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-pink badge-pill">{{@$wdata->category}}</span>
                        </small>
                    </div>
                    @endif
                    @if($wdata->carrier)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.carrier')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->carrier->name}}
                        </small>
                    </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    @if($wdata->status)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.status')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-success badge-pill">{{@$wdata->status->name}}</span>
                        </small>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <h5>{{__('messages.etd')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->etd}}
                        </small>
                    </div>
                    @if($wdata->inbound_status)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.inbound_status')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->inbound_status->name}}
                        </small>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <h5>{{__('messages.memok')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->memok}}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-lg-4">
        <div class="card-box">
            <div class="form-group mb-3">
                <h5>{{__('messages.track_no')}}</h5>
                <small class="text-muted">
                    {{@$wdata->trkNo}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.permit_no')}}</h5>
                <small class="text-muted">
                    {{@$wdata->permit_no}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.pickup')}}</h5>
                <small class="text-muted">
                    {{@$wdata->pickup}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.pickup_date')}}</h5>
                <small class="text-muted">
                    {{@$wdata->pickup_date}}
                </small>
            </div>     
            <div class="form-group mb-3">
                <h5>{{__('messages.created_time')}}</h5>
                <small class="text-muted">
                    {{@$wdata->created_time}}
                </small>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="form-group mb-3">
                <h5>{{__('messages.url')}}</h5>
                <small class="text-muted">
                    <a href="{{@$wdata->arrival_pic_url}}">{{@$wdata->arrival_pic_url}}</a>
                </small>
            </div>
            @if($wdata->attachments)
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.files_attachments')}}</h5>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-centered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 250px;">{{__('messages.attachment_name')}}</th>
                            <th>{{__('messages.files')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wdata->attachments as $index => $file)
                        <tr>
                            <td>{{ucfirst($index)}}</td>
                            <td>
                                @foreach($file as $f)
                                    <a href="{{$f->url}}" target="_blank">
                                        @if($f->ext)
                                            <img src="$f->url" alt="{{$f->file_name}}" height="50">
                                        @else
                                            <img src="{{asset('admin')}}/images/file.jpg" alt="{{$f->file_name}}" height="50">
                                        @endif
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
    @endsection
@endsection