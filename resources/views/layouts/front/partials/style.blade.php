<!-- Plugins css -->
<link href="{{asset('front')}}/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

<!-- App css -->
<link href="{{asset('front')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('front')}}/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('front')}}/css/app.min.css" rel="stylesheet" type="text/css" />
<style>
    .dropdown-megamenu{
        background-image: none;
    }
</style>

<script>
    var baseUrl = "{{ url('/') }}" + '/';
    var csrfToken = "{{csrf_token()}}";
</script>