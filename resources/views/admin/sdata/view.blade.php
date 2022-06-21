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
                        {{@$sdata->name}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.case_number')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->case_number}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.by_country')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->by_country}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.case_in_charge')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->case_in_charge}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.matter_date')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->matter_date}}
                        </small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h5>{{__('messages.priority')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->priority}}
                            
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.ingredient_progress')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->ingredient_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.notification_progress')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->notification_progress}}
                        </small>
                    </div>                    
                    <div class="form-group mb-3">
                        <h5>{{__('messages.sample_progress')}}</h5>
                        <small class="text-muted">
                        {{@$sdata->sample_progress}}
                        </small>
                    </div>
                    <div class="form-group mb-3">
                        <h5>{{__('messages.label_creation_progress')}}</h5>
                        <small class="text-muted">
                            {{@$sdata->label_creation_progress}}
                        </small>
                    </div>
                    
                </div>
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