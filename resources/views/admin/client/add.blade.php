@extends('layouts.layout')
@section('additional-css')
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
    <link href="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2.select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')

<form id="addForm" method="post" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            General Informations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Contact Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#related" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Related Data
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#others" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Others
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="ja_name">{{__('messages.clientjp')}}</label>
                                        <input type="text" name="ja_name" class="form-control">
                                        <div class="invalid-feedback" id="ja_name_error" style="display:none;"></div>
                                    </div>
                            
                                    <div class="form-group mb-3">
                                        <label for="en_name">{{__('messages.clienteng')}}</label>
                                        <input type="text" name="en_name" class="form-control">
                                        <div class="invalid-feedback" id="en_name_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="company_tel">{{__('messages.company_tel')}}</label>
                                        <input type="text" name="company_tel" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="fax">{{__('messages.fax')}}</label>
                                        <input type="text" name="fax" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hp">{{__('messages.hp')}}</label>
                                        <textarea name="hp" class="form-control"></textarea>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="movement">{{__('messages.movement_confirmation')}}</label>
                                        <select class="form-control select2" name="movement">
                                            <option value="">{{__('messages.select_movement_confirmation')}}</option>
                                            @forelse(@$movements as $movement)
                                                <option value="{{$movement->id}}">{{$movement->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="client">{{__('messages.request_customer_association')}}</label>
                                        <select class="form-control select2" name="client">
                                            <option value="">{{__('messages.select_client')}}</option>
                                            @forelse(@$clients as $client)
                                                <option value="{{$client->id}}">{{$client->client_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="shipper">{{__('messages.shipper')}}</label>
                                        <select class="form-control select2" name="shipper">
                                            <option value="">{{__('messages.select_shipper')}}</option>
                                            @forelse($shippers as $shipper)
                                                <option value="{{$shipper->id}}">{{$shipper->shipper_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="shipper_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="request_data">{{__('messages.request')}}</label>
                                        <input type="text" name="request_data" class="form-control">
                                    </div>
                                </div> <!-- end col-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="contact">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">  
                                    <div class="form-group mb-3">
                                        <label for="person_name">{{__('messages.resp_per')}}</label>
                                        <input type="text" name="person_name" class="form-control" placeholder="e.g : John Doe">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact_number">{{__('messages.contact_no')}}</label>
                                        <input type="text" name="contact_number" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="seller_add">{{__('messages.seller_add')}}</label>
                                        <input type="text" name="seller_add" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="office_add">{{__('messages.office_add')}}</label>
                                        <input type="text" name="office_add" class="form-control" placeholder="">
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="email">{{__('messages.email')}}</label>
                                        <input type="text" name="email" class="form-control" placeholder="e.g : john.doe@example.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="seller_name">{{__('messages.seller_name')}}</label>
                                        <input type="text" name="seller_name" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="pic_add">{{__('messages.pick_add')}}</label>
                                        <input type="text" name="pic_add" class="form-control" placeholder="">
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="related">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="category">{{__('messages.docs')}}</label>
                                        <select class="form-control select2" name="category">
                                            <option value="">{{__('messages.select_docs')}}</option>
                                            @foreach($categories as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="category_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="item">{{__('messages.master_data')}}</label>
                                        <select class="form-control select2" name="item[]" multiple>
                                            @forelse($items as $item)
                                                <option value="{{$item->id}}">{{$item->product_name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="item_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="amazon">{{__('messages.amazon_progress')}}</label>
                                        <select class="form-control select2" name="amazon[]" multiple>
                                            @forelse($amazons as $amazon)
                                                <option value="{{$amazon->id}}">{{$amazon->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="amazon_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="delivery_classification">{{__('messages.delivery_classification')}}</label>
                                        <select class="form-control select2" name="delivery_classification">
                                            <option value="">{{__('messages.select_delivery_classification')}}</option>
                                            @forelse($classifications as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <div class="col-lg-8 form-input-area">
                                        <label class="col-form-label">{{__('messages.brand')}}</label>
                                        <div class="row">
                                            <div class="col-sm-9 pl-lg-0">
                                                <div id="dis-clone">
                                                    <div class="row content-box dis-clone" id="clone-0">
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control form-group " placeholder="{{__('messages.brand')}}" name="brand[]">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="#" class="btn btn-success form-button mt-0 add-more-dis">+</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dis-clone-here">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="others">
                    <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="customer_classification">{{__('messages.customer_classification')}}</label>
                                        <input type="text" name="customer_classification" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="takatsu_working_date">{{__('messages.takatsu_working_date')}}</label>
                                        <input type="text" name="takatsu_working_date" class="form-control" placeholder="" id="datetimepicker">
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch" name="sugio_book_print" value="1">
                                            <label class="custom-control-label" for="customSwitch">{{__('messages.sugio_book_print')}}</label>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="yamazaki_book_print" value="1">
                                            <label class="custom-control-label" for="customSwitch1">{{__('messages.yamazaki_book_print')}}</label>
                                        </div>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="warehouse_remarks">{{__('messages.warehouse_remarks')}}</label>
                                        <textarea name="warehouse_remarks" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="invoice_momo">{{__('messages.invoice_momo')}}</label>
                                        <textarea name="invoice_momo" class="form-control"></textarea>
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-client">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.clients.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
<!-- end row -->
    @section('additional-content')
    @endsection
    @section('additional-js')
       <!-- Select2 js-->
        <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
        <script src="{{asset('admin')}}/libs/datetimepicker/moment.min.js" type="text/javascript"></script>
        <script src="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
        <script src="{{asset('admin/custom/js/client.js')}}"></script>
        <script>
            $(".add-more-dis").click(function (e) {
                e.preventDefault();
                var $dis = $("#dis-clone").html();
                $('.dis-clone-here').append($dis);
                $(".dis-clone-here .btn").removeClass("btn-success add-more-dis").addClass("btn-danger remove-clone");
                $(".dis-clone-here .btn").text("-");
                $('.dis-clone-here').find('input:last').val("");
                $('.dis-clone-here').find('.dis-clone').each(function(index, val){
                    index++;
                $(this).attr('id', 'clone-'+index);
                    $(this).find('.error-message').empty().hide();
                });
            });

            $('form#addForm').delegate(".remove-clone","click", function (e) {
                e.preventDefault();
                var thisRef = $(this);
                swal({
                    title: "Are you sure you want to remove this field ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#136ba7",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function (isConfirm){
                    if(isConfirm){
                        thisRef.parent().parent().remove();
                        $('.dis-clone-here').find('.dis-clone').each(function(index, val){
                            index++;
                            $(this).attr('id', 'clone-'+index);
                            $(this).find('.error-message').empty().hide();
                        });
                    }
                });
            });

        </script>
    @endsection
@endsection