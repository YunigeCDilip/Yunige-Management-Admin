@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="clearfix pt-5">
            <h5>Warehouse Data Name</h5>
            <small class="text-muted">
                All accounts are to be paid within 7 days from receipt of
                invoice. To be paid by cheque or credit card or direct payment
                online. If account is not paid within 7 days the credits details
                supplied as confirmation of work undertaken will be charged the
                agreed quoted fee noted above.
            </small>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
    @endsection
@endsection