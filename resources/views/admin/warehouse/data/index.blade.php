@extends('layouts.layout')
@section('additional-css')
    <link href="{{asset('admin/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/buttons.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/libs/datatables/select.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
@endsection
@section('content')    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <a href="{{route('admin.wdata.create')}}" class="btn btn-danger waves-effect waves-light" ><i class="mdi mdi-plus-circle mr-1"></i> Add Warehouse Data</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Client Name</th>
                                <th>Job Type</th>
                                <th>Job</th>
                                <th>Category</th>
                                <th>Permit Number</th>
                                <th>Track Number</th>
                                <th>Deliver</th>
                                <th>Status</th>
                                <th>Create Date</th>
                                <th style="width: 85px;">Action</th>
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