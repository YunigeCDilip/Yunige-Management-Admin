@extends('layouts.layout')
@section('additional-css')
@endsection
@section('content')    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> Add Role</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-striped" id="products-datatable">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Create Date</th>
                                <th style="width: 85px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    New York
                                </td>
                                <td>
                                    07/07/2018
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div> 
    @section('additional-content')
        @include('admin.users.roles.add')
    @endsection
    @section('additional-js')
    <script src="{{asset('admin/custom/js/role.js')}}"></script>
    @endsection
@endsection