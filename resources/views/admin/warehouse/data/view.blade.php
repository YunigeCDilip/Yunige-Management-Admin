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
                            {{@$wdata->fields->Name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.client')}}{{__('messages.name')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->Name}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.pic')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-primary badge-pill">{{@$wdata->fields->pic}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.country')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-secondary badge-pill">{{@$wdata->fields->country[0]}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.category')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-pink badge-pill">{{@$wdata->fields->category}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.carrier')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->deliver}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.status')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-success badge-pill">{{@$wdata->fields->status}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.etd')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->etd}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.inbound_status')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->inboundStatus}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.memok')}}</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->memoK}}
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
                    {{@$wdata->fields->trkNo}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.permit_no')}}</h5>
                <small class="text-muted">
                    {{@$wdata->fields->permitNo}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.pickup')}}</h5>
                <small class="text-muted">
                    {{@$wdata->fields->pickup}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.pickup_date')}}</h5>
                <small class="text-muted">
                    {{@$wdata->fields->pickupDate}}
                </small>
            </div>            
            <div class="form-group mb-3">
                <h5>{{__('messages.total_warehouse')}}</h5>
                <small class="text-muted">
                    {{@$wdata->fields->totalWarehouse}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.created_time')}}</h5>
                <small class="text-muted">
                    {{@$wdata->createdTime}}
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
                    <a href="{{@$wdata->fields->URL}}">{{@$wdata->fields->URL}}</a>
                </small>
            </div>
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.files_attachments')}}</h5>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-centered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 250px;">{{__('messages.attachment_name')}}</th>
                            <th>{{__('messages.files')}}</th>
                            <th style="width: 100px;">{{__('messages.additional_url')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{__('messages.invoices')}}</td>
                            <td>
                                @if(isset($wdata->fields->invoice))
                                    @forelse($wdata->fields->invoice as $invoice)
                                        @if(isset($invoice->type) && $invoice->type == 'application/pdf')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$invoice->filename}}" height="32"></a>
                                        @elseif(isset($invoice->type) && $invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
                                        @elseif(isset($invoice->type) && $invoice->type == 'application/xlsx')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/XLSX.png" alt="{{$invoice->filename}}" height="32"></a>
                                        @elseif(isset($invoice->type) && $invoice->type == 'application/csv')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$invoice->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{$invoice->url}}" alt="{{$invoice->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.import_permit')}}</td>
                            <td>
                                @if(isset($wdata->fields->importPermit))
                                    @forelse($wdata->fields->importPermit as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $permit->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.packing_list')}}</td>
                            <td>
                                @if(isset($wdata->fields->packingList))
                                    @forelse($wdata->fields->packingList as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $permit->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.bl')}}</td>
                            <td>
                                @if(isset($wdata->fields->BL))
                                    @forelse($wdata->fields->BL as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $permit->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.an')}}</td>
                            <td>
                                @if(isset($wdata->fields->AN))
                                    @forelse($wdata->fields->AN as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $permit->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.do')}}</td>
                            <td>
                                @if(isset($wdata->fields->DO))
                                    @forelse($wdata->fields->DO as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $invoice->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.warehouse_invoice')}}</td>
                            <td>
                                @if(isset($wdata->fields->wInvoice))
                                    @forelse($wdata->fields->wInvoice as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $invoice->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.arrival_pic')}}</td>
                            <td>
                                @if(isset($wdata->fields->arrivalPic))
                                    @forelse($wdata->fields->arrivalPic as $permit)
                                        @if(isset($permit->type) && $permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif(isset($permit->type) && $permit->type == 'application/zip')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="32"></a>
                                        @else
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                            <td>
                                @if(isset($wdata->fields->arrivalPicURL) && $wdata->fields->arrivalPicURL != '')
                                    <a href="{{@$wdata->fields->arrivalPicURL}}" class="btn btn-blue waves-effect waves-light">
                                        <i class="mdi mdi-cloud-outline mr-1"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
    @endsection
@endsection