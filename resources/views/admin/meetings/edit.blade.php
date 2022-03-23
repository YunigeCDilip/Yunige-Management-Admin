@extends('layouts.layout')
@section('additional-css')
@endsection

@section('content')

<form action="{{url('meetings/'.$meetingData->id)}}" method="POST"> 

<form id="editForm" method="post" autocomplete="off" class="needs-validation" novalidate>
	@csrf
	<div class="row">
        <div class="col-lg-6">
            <div class="card-box">
            <input id="real-password" type="password" autocomplete="new-password" style="display: none;">
                <div class="form-group mb-3">
                    <label for="topic">{{__('zoom.topic')}} <span class="text-danger">*</span></label>
                    <input type="text" name="topic" class="form-control" value="{{$meetingData->topic}}">

                    <div class="invalid-feedback" id="topic_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="start_time">{{__('zoom.start_time')}} <span class="text-danger">*</span></label>
                    <input type="text" name="start_time" class="form-control" value="{{$meetingData->start_time}}">
                    <div class="invalid-feedback" id="start_time_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="duration">{{__('zoom.duration')}} <span class="text-danger">*</span></label>
                    <input type="text" name="duration" class="form-control" value="{{$meetingData->duration}}">
                    <div class="invalid-feedback" id="duration_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="agenda">{{__('zoom.agenda')}} <span class="text-danger">*</span></label>
                    <input type="text" name="agenda" class="form-control" value="{{$meetingData->agenda}}">
                    <div class="invalid-feedback" id="agenda_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="host_video">{{__('zoom.host_video')}} <span class="text-danger">*</span></label>
                    <input type="text" name="host_video" class="form-control" value="1">
                    <div class="invalid-feedback" id="host_video_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="participant_video">{{__('zoom.participant_video')}} <span class="text-danger">*</span></label>
                    <input type="text" name="participant_video" class="form-control" value="1">
                    <div class="invalid-feedback" id="participant_video_error" style="display:none;"></div>
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
                <a href="{{route('admin.meetings.list')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>


</form>
@endsection



@section('additional-js')
    <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
    <script src="{{asset('admin/custom/js/meetings.js')}}"></script>
@endsection