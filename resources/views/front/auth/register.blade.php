@extends('layouts.front.layout')
@section('additional-css')

@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-pattern">
            <div class="alert alert-success alert-dismissible fade show success-message" role="alert" style="display: none;">
               
            </div>
            <div class="alert alert-danger alert-dismissible fade show error-message" role="alert" style="display: none;">
                
            </div>
            <div class="card-body p-4">
                <form id="registerForm" method="post" class="needs-validation" novalidate="">
                    @csrf
                    <input id="real-password" type="password" autocomplete="new-password" style="display: none;">                                   
                    <div class="form-group mb-3">
                        <label for="fullname">Full Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="fullname" placeholder="Enter your name" name="name">
                        <div class="invalid-feedback" id="name_error" style="display:none;"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="emailaddress">Email Address <span class="text-danger">*</span></label>
                        <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email" name="email">
                        <div class="invalid-feedback" id="email_error" style="display:none;"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input class="form-control" type="password" required="" id="password" placeholder="Enter your password" name="password">
                        <div class="invalid-feedback" id="password_error" style="display:none;"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="comfirm-password">Confirm Password <span class="text-danger">*</span></label>
                        <input class="form-control" type="password" required="" id="comfirm-password" placeholder="Retype your password" name="confirm_password">
                        <div class="invalid-feedback" id="confirm_password_error" style="display:none;"></div>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block btn-register">
                            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                            Register
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
    <script src="{{asset('admin/custom')}}/js/register.js"></script>
@endsection