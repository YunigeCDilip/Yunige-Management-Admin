@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<form id="editForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="wdata_id" value="{{$wdata->id}}">
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            General Informations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#invoice" data-toggle="tab" aria-expanded="true" class="nav-link">
                            Invoice Lists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#permits" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Import Permits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#packing" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Packing Lists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#al" data-toggle="tab" aria-expanded="false" class="nav-link">
                            AN
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#bl" data-toggle="tab" aria-expanded="false" class="nav-link">
                            BL
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#delivery" data-toggle="tab" aria-expanded="false" class="nav-link">
                            DO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#arrival" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Arrival Pic
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="client">{{__('messages.client')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="client[]">
                                            <option value="">{{__('messages.select_client')}}</option>
                                            @forelse(@$clients as $client)
                                                <option value="{{$client->id}}" @if(in_array($client->id, $wdata->fields->client)) selected @endif>{{$client->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="trkNo">{{__('messages.track_no')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="trkNo" class="form-control" placeholder="e.g : 514120049473" value="{{@$wdata->fields->trkNo}}">
                                        <div class="invalid-feedback" id="trkNo_error" style="display:none;"></div>
                                    </div>
                            
                                    <div class="form-group mb-3">
                                        <label for="permitNo">{{__('messages.permit_no')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="permitNo" class="form-control" placeholder="e.g : 10439678210" value="{{@$wdata->fields->permitNo}}">
                                        <div class="invalid-feedback" id="permitNo_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="memoK">{{__('messages.memok')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="memoK" class="form-control" placeholder="e.g : w4065" value="{{@$wdata->fields->memoK}}">
                                        <div class="invalid-feedback" id="mamoK_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="job">{{__('messages.job')}}</label>
                                        <select class="form-control select2" name="job[]">
                                            <option value="">{{__('messages.select_job')}}</option>
                                            @forelse($jobs as $c)
                                                <option value="{{$c}}" @if(@$wdata->fields->job) @if(in_array($c, @$wdata->fields->job)) selected @endif @endif>{{$c}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="panelCheck">{{__('messages.panel_check')}}</label>
                                        <select class="form-control select2" name="panelCheck">
                                            <option value="">{{__('messages.select_panel_check')}}</option>
                                            <option value="1" @if(@$wdata->fields->panelCheck == true) selected @endif>True</option>
                                            <option value="0" @if(@$wdata->fields->panelCheck == false) selected @endif>False</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="outerdamage">{{__('messages.plateNumber')}}</label>
                                        <input type="number" name="plateNumber" class="form-control" placeholder="0" value="{{@$wdata->fields->plateNumber}}">
                                    </div>
                                    {{--<div class="form-group mb-3">
                                        <label for="arrivalCTN">{{__('messages.arrival_ctn')}}</label>
                                        <input type="number" name="arrivalCTN" class="form-control" placeholder="0" value="{{@$wdata->fields->arrivalCTN}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="outerdamage">{{__('messages.outerdamage')}}</label>
                                        <input type="number" name="outerdamage" class="form-control" placeholder="0" value="{{@$wdata->fields->outerdamage}}">
                                    </div>--}}
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="carrier">{{__('messages.carrier')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="carrier[]">
                                            <option value="">{{__('messages.select_carrier')}}</option>
                                            @forelse($carrier as $c)
                                                <option value="{{$c->id}}" @if(@$wdata->fields->carrier) @if(in_array($c->id, @$wdata->fields->carrier)) selected @endif @endif>{{$c->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="carrier_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="pic">{{__('messages.pic')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="pic">
                                            <option value="">{{__('messages.select_pic')}}</option>
                                            @foreach($pic as $value)
                                                <option value="{{$value}}" @if($value = @$wdata->fields->pic) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="pic_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="cat">{{__('messages.category')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="cat[]">
                                            <option value="">{{__('messages.select_category')}}</option>
                                            @foreach($cat as $value)
                                                <option value="{{$value}}" @if(@$wdata->fields->cat) @if(in_array($value, @$wdata->fields->cat)) selected @endif @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="cat_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="status">{{__('messages.status')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="status">
                                            <option value="">{{__('messages.select_status')}}</option>
                                            @foreach($status as $value)
                                                <option value="{{$value}}" @if($value = @$wdata->fields->status) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="inboundStatus">{{__('messages.inbound_status')}}</label>
                                        <select class="form-control select2" name="inboundStatus">
                                            <option value="">{{__('messages.select_inbound_status')}}</option>
                                            @foreach($inboundStatus as $value)
                                                <option value="{{$value}}" @if(@$wdata->fields->inboundStatus == $value) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane show" id="invoice">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3 invoice-file">
                                        <input type="file" name="invoice[]" class="dropify invoice" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="invoice_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        @if($wdata->fields->invoice)
                                            <div class="row">
                                                @foreach($wdata->fields->invoice as $permit)
                                                    <div class="col-sm-2 edit-invoice">
                                                        <tr>
                                                            <td>
                                                                @if(isset($permit->type) && $permit->type == 'application/pdf')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @elseif(isset($permit->type) && $permit->type == 'application/zip')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @elseif(isset($permit->type) && $permit->type == 'application/xlsx' || $permit->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @elseif(isset($permit->type) && $permit->type == 'application/csv')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @else
                                                                <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="invoice_ids[]" value="{{$permit->id}}">
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-permit="{{$permit->id}}">Delete</a>
                                                            </td>
                                                        </tr>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="permits">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">   
                                    <div class="form-group mb-3 permit-file">
                                        <input type="file" name="permit[]" class="dropify permit" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="permit_error" style="display:none;"></div>
                                    </div>
                                </div> <!-- end col-->
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        @if(isset($wdata->fields->importPermit))
                                            <div class="row">
                                                @foreach($wdata->fields->importPermit as $permit)
                                                    <div class="col-sm-2 edit-permit">
                                                        <tr>
                                                            <td>
                                                                @if(isset($packing->type) && $permit->type == 'application/pdf')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @elseif(isset($packing->type) && $permit->type == 'application/zip')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @elseif(isset($packing->type) && $permit->type == 'application/xlsx' || $permit->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @elseif(isset($packing->type) && $permit->type == 'application/csv')
                                                                    <a href="{{$permit->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$permit->filename}}" height="50"></a>
                                                                @else
                                                                <a href="{{$permit->url}}" target="_blank"><img src="{{$permit->url}}" alt="{{$permit->filename}}" height="32"></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="permit_ids[]" value="{{$permit->id}}">
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-permit="{{$permit->id}}">Delete</a>
                                                            </td>
                                                        </tr>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="packing">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3 packing-file">
                                        <input type="file" name="packing[]" class="dropify packing" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="packing_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        @if(isset($wdata->fields->packingList))
                                            <div class="row">
                                                @foreach($wdata->fields->packingList as $packing)
                                                    <div class="col-sm-2 edit-packing">
                                                        <tr>
                                                            <td>
                                                                @if(isset($packing->type) && $packing->type == 'application/pdf')
                                                                    <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$packing->filename}}" height="50"></a>
                                                                @elseif(isset($packing->type) && $packing->type == 'application/zip')
                                                                    <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$packing->filename}}" height="50"></a>
                                                                @elseif(isset($packing->type) && $packing->type == 'application/xlsx' || $packing->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                    <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$packing->filename}}" height="50"></a>
                                                                @elseif(isset($packing->type) && $packing->type == 'application/csv')
                                                                    <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$packing->filename}}" height="50"></a>
                                                                @else
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{$packing->url}}" alt="{{$packing->filename}}" height="32"></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="packing_ids[]" value="{{$packing->id}}">
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-packing="{{$packing->id}}">Delete</a>
                                                            </td>
                                                        </tr>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="al">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3 an-file">
                                        <input type="file" name="an[]" class="dropify an" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="an_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            @if(isset($wdata->fields->AN))
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        @foreach($wdata->fields->AN as $packing)
                                            <div class="col-sm-2 edit-packing">
                                                <tr>
                                                    <td>
                                                        @if($packing->type == 'application/pdf')
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$packing->filename}}" height="50"></a>
                                                        @elseif($packing->type == 'application/zip')
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$packing->filename}}" height="50"></a>
                                                        @elseif($packing->type == 'application/xlsx' || $packing->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$packing->filename}}" height="50"></a>
                                                        @elseif($packing->type == 'application/csv')
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$packing->filename}}" height="50"></a>
                                                        @else
                                                        <a href="{{$packing->url}}" target="_blank"><img src="{{$packing->url}}" alt="{{$packing->filename}}" height="32"></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="an_ids[]" value="{{$packing->id}}">
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-packing="{{$packing->id}}">Delete</a>
                                                    </td>
                                                </tr>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="bl">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3 bl-file">
                                        <input type="file" name="bl[]" class="dropify bl" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="bl_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            @if(isset($wdata->fields->BL))
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <div class="row">
                                            @foreach($wdata->fields->BL as $packing)
                                                <div class="col-sm-2 edit-packing">
                                                    <tr>
                                                        <td>
                                                            @if(isset($packing->type) && $packing->type == 'application/pdf')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/zip')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/xlsx' || $packing->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/csv')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @else
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{$packing->url}}" alt="{{$packing->filename}}" height="32"></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="bl_ids[]" value="{{$packing->id}}">
                                                            <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-packing="{{$packing->id}}">Delete</a>
                                                        </td>
                                                    </tr>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="delivery">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3 do-file">
                                        <input type="file" name="do[]" class="dropify do" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="do_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            @if(isset($wdata->fields->DO))
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <div class="row">
                                            @foreach($wdata->fields->DO as $packing)
                                                <div class="col-sm-2 edit-packing">
                                                    <tr>
                                                        <td>
                                                            @if(isset($packing->type) && $packing->type == 'application/pdf')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/zip')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/xlsx' || $packing->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/csv')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @else
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{$packing->url}}" alt="{{$packing->filename}}" height="32"></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="do_ids[]" value="{{$packing->id}}">
                                                            <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-packing="{{$packing->id}}">Delete</a>
                                                        </td>
                                                    </tr>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="arrival">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3 arrival_pic-file">
                                        <input type="file" name="arrival_pic[]" class="dropify arrival_pic" data-max-file-size="1M" multiple />
                                        <div class="invalid-feedback" id="arrival_pic_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="arrivalPicURL">{{__('messages.arrival_pic_url')}}</label>
                                        <input type="text" name="arrivalPicURL" class="form-control" placeholder="e.g https://example.com" value="{{@$wdata->fields->arrivalPicURL}}">
                                    </div>
                                    @if(isset($wdata->fields->arrivalPic))
                                    <div class="form-group mb-3">
                                        <div class="row">
                                            @foreach($wdata->fields->arrivalPic as $packing)
                                                <div class="col-sm-2 edit-packing">
                                                    <tr>
                                                        <td>
                                                            @if(isset($packing->type) && $packing->type == 'application/pdf')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/pdf.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/zip')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/zip.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/xlsx' || $packing->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/xlsx.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @elseif(isset($packing->type) && $packing->type == 'application/csv')
                                                                <a href="{{$packing->url}}" target="_blank"><img src="{{asset('admin')}}/images/csv.png" alt="{{$packing->filename}}" height="50"></a>
                                                            @else
                                                            <a href="{{$packing->url}}" target="_blank"><img src="{{$packing->url}}" alt="{{$packing->filename}}" height="32"></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="arrival_pic_ids[]" value="{{$packing->id}}">
                                                            <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect waves-light" data-packing="{{$packing->id}}">Delete</a>
                                                        </td>
                                                    </tr>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light updateWdata">
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