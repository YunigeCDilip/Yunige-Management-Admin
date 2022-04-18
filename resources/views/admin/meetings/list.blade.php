@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
    <style>
        .dataTables_filter, .dataTables_length{
            display: none;
        }
        table.dataTable {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <label for="inputPassword2" class="sr-only">{{__('messages.search')}}</label>
                                <input type="search" class="form-control" id="searchForm" placeholder="{{__('messages.search')}}...">
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
                    <div class="col-lg-6">
                        <div class="text-lg-right">
                            <a href="{{route('admin.meetings.create')}}" class="btn btn-danger waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> {{__('zoom.add_new_meeting')}}</a>
                        </div>
                    </div><!-- end col-->
                </div>

                @include('flash-message')
                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('zoom.topic')}}</th>
                                <th>{{__('zoom.meeting_id')}}</th>
                                <th>{{__('zoom.start_time')}}</th>
                                <th>{{__('messages.status')}}</th>
                                <th>{{__('zoom.action')}}</th>
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
    <script src="{{asset('admin/custom/js/meetings.js')}}"></script>
@endsection
