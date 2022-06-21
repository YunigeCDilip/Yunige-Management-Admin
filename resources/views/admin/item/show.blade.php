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
                        {{$item->product_name}}
                        </small>
                    </div>
                    @if($item->clientItems)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.client')}}</h5>
                        <small class="text-muted">
                        {{$item->clientItems->client->client_name}}
                        </small>
                    </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.item_jp')}}</h5>
                        <small class="text-muted">
                            {{$item->jp_name}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.item_en')}}</h5>
                        <small class="text-muted">
                        {{$item->productgname}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    @if($item->brands)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.brand_r')}}</h5>
                        <small class="text-muted">
                            {{$item->brands->name}}
                        </small>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <h5>{{__('messages.barcode')}}</h5>
                        <small class="text-muted">
                            {{$item->product_barcode}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.barcode_entry_date')}}</h5>
                        <small class="text-muted">
                            {{$item->barcode_entry_date}}
                        </small>
                    </div>
                    @if($item->shipper)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.shipper')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-pink badge-pill">
                            {{($item->shipper) ? $item->shipper->shipper_name : ''}}
                            </span>
                        </small>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <h5>{{__('messages.category')}}</h5>
                        <small class="text-muted">
                            <span class="badge badge-primary badge-pill">
                            {{($item->category) ? $item->category->name : ''}}
                            </span>
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ja_description')}}</h5>
                        <small class="text-muted">
                            {{$item->jp_description}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.en_description')}}</h5>
                        <small class="text-muted">
                        {{ $item->description }}
                        </small>
                    </div>
                    @if($item->label)
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label')}}</h5>
                        <small class="text-muted">
                        {{ $item->label->name }}
                        </small>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <h5>{{__('messages.product_types')}}</h5>
                        <small class="text-muted">
                            @forelse($item->productTypes as $d)
                                <span class="badge badge-info badge-pill">
                                    {{$d->type->name}}
                                </span>
                                @empty
                            @endforelse
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.unit')}}</h5>
                        <small class="text-muted">
                            {{$item->unit}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.weight')}}</h5>
                        <small class="text-muted">
                            {{$item->weight}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.weight_2')}}</h5>
                        <small class="text-muted">
                            {{$item->weight2}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.w_no')}}</h5>
                        <small class="text-muted">
                        {{$item->w_no}}
                        </small>
                    </div> 
                    <div class="form-group mb-3">
                        <h5>{{__('messages.lot_no')}}</h5>
                        <small class="text-muted">
                        {{$item->lot_no}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.bbd')}}</h5>
                        <small class="text-muted">
                        {{$item->bbd}}
                        </small>
                    </div>                   
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_date')}}</h5>
                        <small class="text-muted">
                        {{($item->label_date) ? date('F d, Y H:i:s', strtotime($item->label_date)) : ''}}
                        </small>
                    </div>                    
                    <div class="form-group mb-3">
                        <h5>{{__('messages.lot_arr_date')}}</h5>
                        <small class="text-muted">
                        {{($item->lot_arr_date) ? date('F d, Y H:i:s', strtotime($item->lot_arr_date)) : ''}}
                        </small>
                    </div>                
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sample_date')}}</h5>
                        <small class="text-muted">
                        {{($item->sample_date) ? date('F d, Y H:i:s', strtotime($item->sample_date)) : ''}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_remarks')}}</h5>
                        <small class="text-muted">
                        {{$item->label_remarks}}
                        </small>
                    </div>  
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-lg-4">
        <div class="card-box">
            <div class="form-group mb-3">
                <h5>{{__('messages.sampling')}}</h5>
                <small class="text-muted">
                {{$item->sampling}}
                </small>
            </div>            
            <div class="form-group mb-3">
                <h5>{{__('messages.lot_sampling')}}</h5>
                <small class="text-muted">
                {{$item->lot_sampling}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.outer_height')}}</h5>
                <small class="text-muted">
                {{$item->outer_height}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.outer_width')}}</h5>
                <small class="text-muted">
                {{$item->outer_width}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.unit_width')}}</h5>
                <small class="text-muted">
                {{$item->unit_width}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.unit_height')}}</h5>
                <small class="text-muted">
                {{$item->unit_height}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.origin')}}</h5>
                <small class="text-muted">
                {{$item->origin}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.amazon_req')}}</h5>
                <small class="text-muted">
                {{$item->amazon_req}}
                </small>
            </div>
            <div class="form-group mb-3">
                <h5>{{__('messages.outer_label_pos')}}</h5>
                <small class="text-muted">
                {{$item->outer_label_pos}}
                </small>
            </div>
        </div>
    </div> <!-- end col -->
</div>

@if($item->images)
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-centered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('messages.files')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @foreach($item->images as $f)
                                    <a href="{{$f->url}}" target="_blank">
                                        <img src="{{$f->url}}" alt="Image" height="50">
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
@endif
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
    @endsection
@endsection