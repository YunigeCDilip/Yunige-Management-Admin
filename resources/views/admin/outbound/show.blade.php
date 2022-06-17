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
                        {{@$outbound->name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.wdata')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->wdata->name}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.warehouse_in_charge')}}</h5>
                        <small class="text-muted">
                            @if($warehouseIncharge)
                                @foreach($warehouseIncharge as $i)
                                    <span class="badge badge-secondary badge-pill">{{$i}}</span>
                                @endforeach
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.reserve')}}</h5>
                        <small class="text-muted">
                            @if(@$outbound->reserve)
                            <span class="badge badge-success badge-pill"><i class="fe-check-square"></i></span>
                            @else
                            <span class="badge badge-danger badge-pill"><i class="fe-x-circle"></i></span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ship_date')}}</h5>
                        @if($outbound->ship_date)
                        <small class="text-muted">
                            {{date('F d, Y', strtotime($outbound->ship_date))}}
                        </small>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.delivery_id')}}</h5>
                        <small class="text-muted">
                            @if($outbound->delivery)
                            <span class="badge badge-pink badge-pill">
                            {{(@$outbound->delivery) ? @$outbound->delivery->name : ''}}
                            </span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.create_date')}}</h5>
                        @if($outbound->create_date)
                        <small class="text-muted">
                            {{date('F d, Y', strtotime($outbound->create_date))}}
                        </small>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.completed')}}</h5>
                        <small class="text-muted">
                            @if(@$outbound->completed)
                            <span class="badge badge-success badge-pill">True</span>
                            @else
                            <span class="badge badge-danger badge-pill">False</span>
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.invoice_no')}}</h5>
                        <small class="text-muted">
                        {{ @$outbound->invoice_no }}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.additional_invoice_no')}}</h5>
                        <small class="text-muted">
                        {{ @$outbound->additional_invoice_no }}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fba_reservation_no')}}</h5>
                        <small class="text-muted">
                        {{ @$outbound->fba_reservation_no }}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fba_entry_date')}}</h5>
                        <small class="text-muted">
                            {{@$outbound->fba_entry_date}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fba_no')}}</h5>
                        <small class="text-muted">
                        {{@$outbound->fba_no}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.po_no')}}</h5>
                        <small class="text-muted">
                        {{@$outbound->po_no}}
                        </small>
                    </div>  
                    <div class="form-group mb-3">
                        <h5>{{__('messages.fba_lists')}}</h5>
                        <small class="text-muted">
                        {{@$outbound->po_no}}
                        </small>
                    </div>  
                    <div class="form-group mb-3">
                        <h5>{{__('messages.url')}}</h5>
                        <small class="text-muted">
                            @if($outbound->next_url)
                            {{@$outbound->url.$outbound->next_url}}
                            @else
                            {{@$outbound->url}}
                            @endif
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.mail_text')}}</h5>
                        <small class="text-muted">
                        {{@$outbound->mail_text}}
                        </small>
                    </div>           
                </div>
            </div>

            @if($attachments)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
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
                                    @foreach($attachments as $index => $file)
                                    <tr>
                                        <td>{{ucfirst($index)}}</td>
                                        <td>
                                            @foreach($file as $f)
                                                <a href="{{$f->url}}" target="_blank">
                                                    <img src="{{asset('admin')}}/images/file.jpg" alt="{{$f->file_name}}" height="50">
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
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