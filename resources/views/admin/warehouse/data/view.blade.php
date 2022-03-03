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
                <div class="form-group mb-3">
                    <h5>Warehouse Data Name</h5>
                    <small class="text-muted">
                        {{@$wdata->fields->Name}}
                    </small>
                </div>
                <div class="form-group mb-3">
                    <h5>Client Name</h5>
                    <small class="text-muted">
                        {{@$wdata->fields->Name}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>Pic</h5>
                        <small class="text-muted">
                            <span class="badge badge-primary badge-pill">{{@$wdata->fields->pic}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>Country</h5>
                        <small class="text-muted">
                            <span class="badge badge-secondary badge-pill">{{@$wdata->fields->country[0]}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>Category</h5>
                        <small class="text-muted">
                            <span class="badge badge-pink badge-pill">{{@$wdata->fields->category}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>Carrier</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->deliver}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>Status</h5>
                        <small class="text-muted">
                            <span class="badge badge-success badge-pill">{{@$wdata->fields->status}}</span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>Etd</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->etd}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>Inbound Status</h5>
                        <small class="text-muted">
                            {{@$wdata->fields->inboundStatus}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>Memok</h5>
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
                <h5>Track Number</h5>
                <small class="text-muted">
                    {{@$wdata->fields->trkNo}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>Permit Number</h5>
                <small class="text-muted">
                    {{@$wdata->fields->permitNo}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>Pickup</h5>
                <small class="text-muted">
                    {{@$wdata->fields->pickup}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>Pickup Date</h5>
                <small class="text-muted">
                    {{@$wdata->fields->pickupDate}}
                </small>
            </div>            
            <div class="form-group mb-3">
                <h5>Total Warehouse</h5>
                <small class="text-muted">
                    {{@$wdata->fields->totalWarehouse}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>Created Time</h5>
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
                <h5>URL</h5>
                <small class="text-muted">
                    <a href="{{@$wdata->fields->URL}}">{{@$wdata->fields->URL}}</a>
                </small>
            </div>
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Files & Attachments</h5>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-centered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 250px;">Attachments Name</th>
                            <th>Files</th>
                            <th style="width: 100px;">Additional URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Invoices</td>
                            <td>
                                @if(isset($wdata->fields->invoice))
                                    @forelse($wdata->fields->invoice as $invoice)
                                        @if($invoice->type == 'application/pdf')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$invoice->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>Import Permits</td>
                            <td>
                                @if(isset($wdata->fields->importPermit))
                                    @forelse($wdata->fields->importPermit as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>Packing Lists</td>
                            <td>
                                @if(isset($wdata->fields->packingList))
                                    @forelse($wdata->fields->packingList as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>BL</td>
                            <td>
                                @if(isset($wdata->fields->BL))
                                    @forelse($wdata->fields->BL as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>AN</td>
                            <td>
                                @if(isset($wdata->fields->AN))
                                    @forelse($wdata->fields->AN as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>DO</td>
                            <td>
                                @if(isset($wdata->fields->DO))
                                    @forelse($wdata->fields->DO as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>Warehouse Invoice</td>
                            <td>
                                @if(isset($wdata->fields->wInvoice))
                                    @forelse($wdata->fields->wInvoice as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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
                            <td>Arrival Pic</td>
                            <td>
                                @if(isset($wdata->fields->arrivalPic))
                                    @forelse($wdata->fields->arrivalPic as $permit)
                                        @if($permit->type == 'application/pdf')
                                            <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="32"></a>
                                        @elseif($invoice->type == 'application/zip')
                                            <a href="{{$invoice->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$invoice->filename}}" height="32"></a>
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