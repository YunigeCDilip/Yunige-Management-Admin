@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
    <style>
        .dataTables_filter, .dataTables_length{
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-8">
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <label for="inputPassword2" class="sr-only">Search</label>
                                <input type="search" class="form-control" id="searchForm" placeholder="Search...">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <select class="custom-select" id="page-select">
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </form>                            
                    </div>
                    @if(auth()->user()->can('manage.user'))
                        <div class="col-lg-4">
                            <div class="text-lg-right">
                                <a href="{{route('admin.users.create')}}" class="btn btn-danger waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> Add New User</a>
                            </div>
                        </div><!-- end col-->
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-centered mb-0" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
@endsection
@section('additional-js')
    <script src="{{asset('admin')}}/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin')}}/libs/datatables/dataTables.bootstrap4.js"></script>
    <script src="{{asset('admin')}}/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="{{asset('admin')}}/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
    <script src="{{asset('admin/custom/js/user.js')}}"></script>
@endsection