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
                    <div class="col-lg-4">
                        <div class="text-lg-right">
                            <a href="{{route('admin.rooms.create')}}" class="btn btn-danger waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> {{__('zoom.add_new_room')}}</a>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('zoom.topic')}}</th>
                                <th>{{__('zoom.activation_code')}}</th>
                                <th>{{__('zoom.action')}}</th>
                            </tr>
                            @foreach ($rooms['data']['rooms'] as $roomData)
                            <tr>
                            <td>{{ $roomData['name'] }}</td>
                            <td>{{ $roomData['activation_code'] }}</td>
                            
                            
                            
                            <td>
                                <a href="#" class="action-icon edit-role"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>
                                <a href="#" class="action-icon delete-role"> <i class="mdi mdi-delete text-danger"></i></a>
                            </td>
                        </tr>
                        @endforeach

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