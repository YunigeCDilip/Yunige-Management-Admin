@extends('layouts.layout')
@section('additional-css')
@endsection
@section('content')
<form id="editForm" autocomplete="off" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
            <input id="real-password" type="password" autocomplete="new-password" style="display: none;">
            <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="form-group mb-3">
                    <label for="name">{{__('messages.name')}} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{$user->name}}">
                    <div class="invalid-feedback" id="name_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="email">{{__('messages.email')}} <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control" value="{{$user->email}}">
                    <div class="invalid-feedback" id="email_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="phone">{{__('messages.phone')}}</label>
                    <input type="text" name="phone" class="form-control" value="{{$user->phone}}">
                </div>
                
                <div class="form-group mb-3">
                    <label for="address">{{__('messages.address')}}</label>
                    <input type="text" name="address" class="form-control" value="{{$user->address}}">
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="status">
                        <option value="">{{__('messages.select_status')}}</option>
                        <option value="1" @if($user->active_status) selected @endif>{{__('messages.active')}}</option>
                        <option value="0" @if(!$user->active_status) selected @endif>{{__('messages.inactive')}}</option>
                    </select>
                    <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">
                <a class="change-password" data-toggle="collapse"
                                               href="#change-pass" role="button" aria-expanded="false"
                                               aria-controls="collapseExample" style="float: right;">{{__('messages.change_password')}}</a>
                <div class="form-group mb-3 collapse" id="change-pass">
                    <div class="form-group mb-3">
                        <label for="password">{{__('messages.password')}} <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="" disabled>
                        <div class="invalid-feedback" id="password_error" style="display:none;"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="confirm_password">{{__('messages.confirm_password')}} <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="" disabled>
                        <div class="invalid-feedback" id="confirm_password_error" style="display:none;"></div>
                    </div>   
                </div>

                <div class="form-group mb-3">
                    <label for="role">{{__('messages.role')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="role">
                        <option value="">{{__('messages.select_role')}}</option>
                        @forelse(@$roles as $role)
                            <option value="{{$role->id}}" @if(!$user->roles->isEmpty()) @if($user->roles[0]->id == $role->id) selected @endif @endif>{{$role->name}}</option>
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
                                    <input type="checkbox" class="custom-control-input" id="{{$p->name}}" value="{{$p->id}}" name="permissions[]" @if(in_array($p->id, $permissionSelected)) checked @endif>
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
                <a href="javascript:void(0)" class="btn w-sm btn-success waves-effect waves-light update-user">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </a>
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