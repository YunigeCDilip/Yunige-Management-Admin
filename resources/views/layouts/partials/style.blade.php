<!-- Plugins css -->
<link href="{{asset('admin/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />

<!-- App css -->
<link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Custom box css -->
<link href="{{asset('admin/libs/custombox/custombox.min.css')}}" rel="stylesheet">

<!-- Jquery Toast css -->
<link href="{{asset('admin/libs/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin/custom/css/custom.css')}}" rel="stylesheet" type="text/css" />

<script>
    var baseUrl = "{{ url('/') }}" + '/';
    var csrfToken = "{{csrf_token()}}";
</script>