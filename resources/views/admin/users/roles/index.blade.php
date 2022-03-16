@extends('layouts.layout')
@section('additional-css')
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
@endsection
@section('content')    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> {{__('role.add_role')}}</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0" id="role-table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('role.role_name')}}</th>
                                <th>{{__('role.created_date')}}</th>
                                <th style="width: 250px;">{{__('actions.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr data-id="{{$role->id}}">
                                    <td>
                                        {{$role->name}}
                                    </td>
                                    <td>
                                        {{$role->created_at->format('M d, Y')}}
                                    </td>
                                    <td>
                                        @if($role->editable)
                                            <a href="javascript:void(0);" class="action-icon edit-role"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>
                                            <a href="javascript:void(0);" class="action-icon delete-role"> <i class="mdi mdi-delete text-danger"></i></a>
                                        @else
                                            <p>No Action Available</p>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $roles->links('admin.common.paginator') }}
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div> 
    @section('additional-content')
        @include('admin.users.roles.add')
        @include('admin.users.roles.edit')
    @endsection
    @section('additional-js')
    <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
    <script src="{{asset('admin/custom/js/role.js')}}"></script>
    @endsection
@endsection