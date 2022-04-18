@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin/libs/datetimepicker/jquerysctipttop.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('admin/libs/datetimepicker/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/libs/datetimepicker/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/libs/datetimepicker/bootstrap-datetimepicker.min.css')}}">

    <style>
        body { background-color: #fafafa; }
        .container { margin-top: 150px; }
    </style>
@endsection
@section('content')
<form action="{{url('meetings/create')}}" method="POST"> 
<form id="addForm" method="post" autocomplete="off" class="needs-validation" novalidate>
	@csrf
	<div class="row">
        <div class="col-lg-6">
            <div class="card-box">
            <input id="real-password" type="password" autocomplete="new-password" style="display: none;">
                <div class="form-group mb-3">
                    <label for="topic">{{__('zoom.topic')}} <span class="text-danger">*</span></label>
                    <input type="text" name="topic" class="form-control" placeholder="Meeting Topic">
                    <div class="invalid-feedback" id="topic_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="start_time">{{__('zoom.start_time')}} <span class="text-danger">*</span></label>
                    <input type="text" name="start_time" class="form-control" placeholder="start_time" id="datetimepicker1" />
                    <div class="invalid-feedback" id="start_time_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="duration">{{__('zoom.duration')}} <span class="text-danger">*</span></label>
                    <input type="text" name="duration" class="form-control" placeholder="duration">
                    <div class="invalid-feedback" id="duration_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="agenda">{{__('zoom.agenda')}} <span class="text-danger">*</span></label>
                    <input type="text" name="agenda" class="form-control" placeholder="agenda">
                    <div class="invalid-feedback" id="agenda_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="host_video">{{__('zoom.host_video')}} <span class="text-danger">*</span></label>
                    <input type="text" name="host_video" class="form-control" placeholder="host_video">
                    <div class="invalid-feedback" id="host_video_error" style="display:none;"></div>
                </div>

				<div class="form-group mb-3">
                    <label for="participant_video">{{__('zoom.participant_video')}} <span class="text-danger">*</span></label>
                    <input type="text" name="participant_video" class="form-control" placeholder="participant_video">
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

<script src="{{asset('admin')}}/libs/datetimepicker/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="{{asset('admin')}}/libs/datetimepicker/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{{asset('admin')}}/libs/datetimepicker/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{asset('admin')}}/libs/datetimepicker/moment.min.js" type="text/javascript"></script>
<script src="{{asset('admin')}}/libs/datetimepicker/bootstrap-datetimepicker.min.js"></script>

        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
@endsection

