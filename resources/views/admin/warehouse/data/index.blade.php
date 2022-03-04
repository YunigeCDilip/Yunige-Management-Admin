@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/buttons.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/select.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
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
                    <div class="col-lg-8">
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
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                        <a href="{{route('admin.wdata.create')}}" class="btn btn-danger waves-effect waves-light" ><i class="mdi mdi-plus-circle mr-1"></i> {{__('messages.add_new_wdata')}}</a>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('messages.name')}}</th>
                                <th>{{__('messages.client_name')}}</th>
                                <th>{{__('messages.permit_no')}}</th>
                                <th>{{__('messages.track_no')}}</th>
                                <th>{{__('messages.country')}}</th>
                                <th>{{__('messages.carrier')}}</th>
                                <th>{{__('messages.category')}}</th>
                                <th>{{__('messages.status')}}</th>
                                <th>{{__('messages.created_date')}}</th>
                                <th style="width: 85px;">{{__('messages.action')}}</th>
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
    @section('additional-content')
    @endsection
    @section('additional-js')
        <script src="{{asset('admin')}}/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/dataTables.bootstrap4.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/responsive.bootstrap4.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/buttons.html5.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/buttons.flash.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/buttons.print.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="{{asset('admin')}}/libs/datatables/dataTables.select.min.js"></script>
        <script src="{{asset('admin')}}/libs/pdfmake/pdfmake.min.js"></script>
        <script src="{{asset('admin')}}/libs/pdfmake/vfs_fonts.js"></script>
        <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
        <script src="{{asset('admin/custom/js/warehouse.js')}}"></script>
    @endsection
@endsection