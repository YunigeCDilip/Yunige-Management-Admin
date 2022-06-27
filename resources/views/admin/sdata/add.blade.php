@extends('layouts.layout')
@section('additional-css')
@endsection
@section('content')
<form id="addForm" method="post" autocomplete="off" class="needs-validation" novalidate>
	@csrf
	<div class="row">
        <div class="col-lg-6">
            <div class="card-box">
            <input id="real-password" type="password" autocomplete="new-password" style="display: none;">
                <div class="form-group mb-3">
                    <label for="name">{{__('messages.name')}} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="fba name">
                    <div class="invalid-feedback" id="name_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="case_number">{{__('messages.case_number')}} <span class="text-danger">*</span></label>
                    <input type="text" name="case_number" class="form-control" placeholder="case_number">
                    <div class="invalid-feedback" id="case_number_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="by_country">{{__('messages.by_country')}} <span class="text-danger">*</span></label>
                    <input type="text" name="by_country" class="form-control" placeholder="by_country">
                    <div class="invalid-feedback" id="by_country_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="case_in_charge">{{__('messages.case_in_charge')}} <span class="text-danger">*</span></label>
                    <input type="text" name="case_in_charge" class="form-control" placeholder="case_in_charge">
                    <div class="invalid-feedback" id="case_in_charge_error" style="display:none;"></div>
                </div>
				<div class="form-group mb-3">
                    <label for="matter_date">{{__('messages.matter_date')}} <span class="text-danger">*</span></label>
                    <input type="text" name="matter_date" class="form-control" placeholder="matter_date">
                    <div class="invalid-feedback" id="matter_date_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="priority">{{__('messages.priority')}} <span class="text-danger">*</span></label>
                    <input type="text" name="priority" class="form-control" placeholder="priority">
                    <div class="invalid-feedback" id="priority_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="ingredient_progress">{{__('messages.ingredient_progress')}} <span class="text-danger">*</span></label>
                    <input type="text" name="ingredient_progress" class="form-control" placeholder="ingredient_progress">
                    <div class="invalid-feedback" id="ingredient_progress_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="notification_progress">{{__('messages.notification_progress')}} <span class="text-danger">*</span></label>
                    <input type="text" name="notification_progress" class="form-control" placeholder="notification_progress">
                    <div class="invalid-feedback" id="notification_progress_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="sample_progress">{{__('messages.sample_progress')}} <span class="text-danger">*</span></label>
                    <input type="text" name="sample_progress" class="form-control" placeholder="sample_progress">
                    <div class="invalid-feedback" id="sample_progress_error" style="display:none;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="label_creation_progress">{{__('messages.label_creation_progress')}} <span class="text-danger">*</span></label>
                    <input type="text" name="label_creation_progress" class="form-control" placeholder="label_creation_progress">
                    <div class="invalid-feedback" id="label_creation_progress_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        
    </div>
	<div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-sdata">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.sdata.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>


</form>
@endsection
@section('additional-js')
<script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
<script src="{{asset('admin')}}/libs/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
<script src="{{asset('admin/custom/js/sdata.js')}}"></script>
@endsection