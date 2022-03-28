@extends('layouts.layout')
@section('additional-css')
@endsection
@section('content')

<form action="{{url('rooms/'.$roomData->id)}}" method="POST"> 

<form id="addForm" method="post" autocomplete="off" class="needs-validation" novalidate>
	@csrf
	<div class="row">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="name">{{__('zoom.room_name')}} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{$roomData->name}}">
                    <div class="invalid-feedback" id="name_error" style="display:none;"></div>
                </div>

                
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        
    </div>
	<div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-user">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.rooms.list')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>


</form>
@endsection
