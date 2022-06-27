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
                    <label for="fba_name">{{__('messages.fba_name')}} <span class="text-danger">*</span></label>
                    <input type="text" name="fba_name" class="form-control" placeholder="fba name">
                    <div class="invalid-feedback" id="fba_name_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="notes">{{__('messages.notes')}} <span class="text-danger">*</span></label>
                    <input type="text" name="notes" class="form-control" placeholder="notes">
                    <div class="invalid-feedback" id="notes_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="label">{{__('messages.label')}} <span class="text-danger">*</span></label>
                    <input type="text" name="label" class="form-control" placeholder="label">
                    <div class="invalid-feedback" id="label_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="address">{{__('messages.address')}} <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" placeholder="address">
                    <div class="invalid-feedback" id="address_error" style="display:none;"></div>
                </div>
                
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        
    </div>
	<div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-fba">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.fba.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>


</form>
@endsection
@section('additional-js')
<script src="{{asset('admin')}}/libs/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
<script src="{{asset('admin/custom/js/fba.js')}}"></script>
@endsection