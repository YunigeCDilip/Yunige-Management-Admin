@extends('layouts.front.layout')
@section('additional-css')

@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="alert alert-danger alert-dismissible fade show message" role="alert" style="display: none;">
        </div>
        <div class="card bg-pattern">
            <div class="card-body p-4">
            <form id="loginForm" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="form-group mb-3">
                    <label for="emailaddress">{{__('login.email')}}</label>
                    <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email" name="email">
                    <div class="invalid-feedback" id="email_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="password">{{__('login.password')}}</label>
                    <input class="form-control" type="password" required="" id="password" placeholder="Enter your password" name="password">
                    <div class="invalid-feedback" id="password_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked name="remember_me">
                        <label class="custom-control-label" for="checkbox-signin">{{__('login.remember_me')}}</label>
                    </div>
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-block btn-login">
                        <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                        {{__('login.log_in')}}
                    </button>
                </div>

            </form>

            </div> <!-- end card-body -->
        </div>
        <!-- end card -->
        <!-- end row -->

    </div> <!-- end col -->
</div>
@endsection
@section('additional-js')
    <script src="{{asset('admin/custom')}}/js/login.js"></script>
@endsection