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
                                    <option value="25" selected>25</option>
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
                        <a href="{{route('admin.sdata.create')}}" class="btn btn-danger waves-effect waves-light" ><i class="mdi mdi-plus-circle mr-1"></i> {{__('messages.add_new_sdata')}}</a>
                        </div>
                    </div>
                    <!-- end col-->
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('messages.id')}}</th>
                                <th>{{__('messages.name')}}</th>
                                <th>{{__('messages.case_number')}}</th>
                                <th>{{__('messages.by_country')}}</th>
                                <th>{{__('messages.case_in_charge')}}</th>
                                <th>{{__('messages.matter_date')}}</th>
                                <th>{{__('messages.priority')}}</th>
                                <th>{{__('messages.ingredient_progress')}}</th>
                                <th>{{__('messages.notification_progress')}}</th>
                                <th>{{__('messages.sample_progress')}}</th>
                                <th>{{__('messages.label_creation_progress')}}</th>
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
        <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
        <script src="{{asset('admin/custom/js/sdata.js')}}"></script>
    @endsection
@endsection