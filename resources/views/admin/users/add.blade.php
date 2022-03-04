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
                    <input type="text" name="name" class="form-control" placeholder="John Doe">
                    <div class="invalid-feedback" id="name_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="email">{{__('messages.email')}} <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control" placeholder="john.yunige@gmail.com">
                    <div class="invalid-feedback" id="email_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="phone">{{__('messages.phone')}}</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                
                <div class="form-group mb-3">
                    <label for="address">{{__('messages.address')}}</label>
                    <input type="text" name="address" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="status">{{__('messages.status')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="status">
                        <option value="">{{__('messages.select_status')}}</option>
                        <option value="1">{{__('messages.active')}}</option>
                        <option value="0">{{__('messages.inactive')}}</option>
                    </select>
                    <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">
                        
                <div class="form-group mb-3">
                    <label for="password">{{__('messages.password')}} <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="">
                    <div class="invalid-feedback" id="password_error" style="display:none;"></div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="confirm_password">{{__('messages.confirm_password')}} <span class="text-danger">*</span></label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="">
                    <div class="invalid-feedback" id="confirm_password_error" style="display:none;"></div>
                </div>   

                <div class="form-group mb-3">
                    <label for="role">{{__('messages.role')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="role">
                        <option value="">{{__('messages.select_role')}}</option>
                        @forelse(@$roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="role_error" style="display:none;"></div>
                </div>
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.permissions')}}</h5>
                <div class="invalid-feedback" id="permissions_error" style="display:none;"></div>
                @forelse($permissions as $index => $permission)
                    <div class="form-group mb-3 invoice-file">
                        <div class="col-lg-6">
                            <label for="role"><strong>{{ucfirst($index)}} Permissions</strong></label>
                            @foreach($permission as $p)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{$p->name}}" value="{{$p->id}}" name="permissions[]">
                                    <label class="custom-control-label" for="{{$p->name}}">{{$p->display_name}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                @endforelse
            </div> <!-- end col-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-user">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.users.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('additional-js')
    <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
    <script src="{{asset('admin/custom/js/user.js')}}"></script>
@endsection