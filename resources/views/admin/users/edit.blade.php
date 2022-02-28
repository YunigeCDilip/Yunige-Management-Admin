@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin')}}/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<form id="editForm" method="post" autocomplete="off" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
            <input id="real-password" type="password" autocomplete="new-password" style="display: none;">
                <div class="form-group mb-3">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{$user->name}}">
                    <div class="invalid-feedback" id="name_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control" value="{{$user->email}}">
                    <div class="invalid-feedback" id="email_error" style="display:none;"></div>
                </div>
        
                <div class="form-group mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{$user->phone}}">
                </div>
                
                <div class="form-group mb-3">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" value="{{$user->address}}">
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="status">
                        <option value="">Select Status</option>
                        <option value="1" @if($user->active_status) selected @endif>Active</option>
                        <option value="0" @if(!$user->active_status) selected @endif>In Active</option>
                    </select>
                    <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">
                <div class="col-lg-6 form-input-area collapse" id="change-pass">
                    <div class="form-group mb-3">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="">
                        <div class="invalid-feedback" id="password_error" style="display:none;"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="">
                        <div class="invalid-feedback" id="confirm_password_error" style="display:none;"></div>
                    </div>   
                </div>

                <div class="form-group mb-3">
                    <label for="role">Role <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="role">
                        <option value="">Select Role</option>
                        @forelse(@$roles as $role)
                            <option value="{{$role->id}}" @if(!$user->roles->isEmpty()) @if($user->roles[0]->id == $role->id) selected @endif @endif>{{$role->name}}</option>
                            @empty
                        @endforelse
                    </select>
                    <div class="invalid-feedback" id="role_error" style="display:none;"></div>
                </div>
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Permissions</h5>
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
                <button class="btn w-sm btn-success waves-effect waves-light save-user">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    Save
                </button>
                <a href="{{route('admin.users.index')}}" class="btn w-sm btn-danger waves-effect">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('additional-js')
    <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
    <script src="{{asset('admin/custom/js/user.js')}}"></script>
@endsection