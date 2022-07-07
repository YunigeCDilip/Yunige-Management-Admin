@extends('layouts.layout')
@section('additional-css')
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
    <link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2.select2-container {
            width: 100% !important;
        }
        .modal-demo{
            overflow: scroll;
        }
        .pull-right{
            float: right;
        }
    </style>
    @endsection
@section('content')

<form id="addForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                        {{__('messages.general_info')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#producttab" data-toggle="tab" aria-expanded="false" class="nav-link ">
                        {{__('messages.product_list')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#attachments" data-toggle="tab" aria-expanded="false" class="nav-link">
                        {{__('messages.attach')}}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="user">{{__('messages.w_project_charge')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="user">
                                            <option value="">{{__('messages.select_user')}}</option>
                                            @forelse(@$users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="transport">{{__('messages.transportation_method')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="transport">
                                            <option value="">{{__('messages.select_transport')}}</option>
                                            <option value="sea">sea</option>
                                            <option value="air">air</option>
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="incoterms">{{__('messages.incoterms')}} <span class="text-danger">*</span></label>
                                        <textarea name="incoterms" class="form-control"></textarea>
                                        <div class="invalid-feedback" id="incoterms_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="cat">{{__('messages.category_classification')}}<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="cat[]">
                                            <option value="">{{__('messages.select_category')}}</option>
<<<<<<< HEAD
                                            @forelse($cat as $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                                @empty
                                            @endforelse
=======
                                            @foreach($cat as $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
>>>>>>> ca5061d62b03a89dbaada56d31483d73021663ef
                                        </select>
                                        <div class="invalid-feedback" id="cat_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="client">{{__('messages.customer_link')}} <span class="text-danger">*</span></label>
                                        <a href="javascript:void(0)" class="btn btn-success btn-xs form-button mt-0 add-new-client float-right">+</a>
                                        <select class="form-control select2" name="client">
                                            <option value="">{{__('messages.select_client')}}</option>
                                            @forelse(@$clients as $client)
                                                <option value="{{$client->id}}">{{$client->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="client_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="arrival_place">{{__('messages.arrival_place')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="arrival_place">
                                            <option value="">{{__('messages.select_arrival_place')}}</option>
                                            @forelse($carrier as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="arrival_place_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="shipping_company">{{__('messages.shipping_company')}}</label>
                                        <select class="form-control select2" name="shipping_company">
                                            <option value="">{{__('messages.select_shipping_company')}}</option>
<<<<<<< HEAD
                                            @forelse($shipments as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @empty
                                            @endforelse
=======
                                            @foreach($shipments as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
>>>>>>> ca5061d62b03a89dbaada56d31483d73021663ef
                                        </select>
                                        <div class="invalid-feedback" id="shipping_company_error" style="display:none;"></div>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <div class="form-group mb-3">
                                        <label for="trkNo">{{__('messages.track_no')}}</label>
                                        <input type="text" name="trkNo" class="form-control" placeholder="e.g : 514120049473">
                                        <div class="invalid-feedback" id="trkNo_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="eta">{{__('messages.eta')}}</label>
                                        <input type="text" name="eta" class="form-control datetimepicker" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customs_broker">{{__('messages.customs_broker')}}</label>
                                        <select class="form-control select2" name="customs_broker">
                                            <option value="">{{__('messages.select_customs_broker')}}</option>
                                            @forelse($customBrokers as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @empty
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="document_case">{{__('messages.document_case')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="document_case" class="form-control">
                                        <div class="invalid-feedback" id="document_case_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="arrival_progresses">{{__('messages.arrival_progresses')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="arrival_progress">
                                            <option value="">{{__('messages.select_arrival_progress')}}</option>
<<<<<<< HEAD
                                            @forelse($status as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @empty
                                            @endforelse
=======
                                            @foreach($status as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
>>>>>>> ca5061d62b03a89dbaada56d31483d73021663ef
                                        </select>
                                        <div class="invalid-feedback" id="status_error" style="display:none;"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="goods_progress">{{__('messages.goods_progress')}} <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="goods_progress">
                                            <option value="">{{__('messages.select_goods_progress')}}</option>
<<<<<<< HEAD
                                            @forelse($inboundStatus as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @empty
                                            @endforelse
=======
                                            @foreach($inboundStatus as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
>>>>>>> ca5061d62b03a89dbaada56d31483d73021663ef
                                        </select>
                                        <div class="invalid-feedback" id="goods_progress_error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="overal_work_instruction">{{__('messages.overal_work_instruction')}} <span><i class="mdi mdi-information" title="{{__('messages.instruction_note')}}" data-plugin="tippy" data-tippy-duration="[500, 200]"></i></span></label>
                                        <textarea name="overal_work_instruction" class="form-control"></textarea>
                                        <div class="invalid-feedback" id="overal_work_instruction_error" style="display:none;"></div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="producttab">
                        <div id="dis-clone">
                            <a href="#" class="btn btn-secondary btn-xs form-button mt-0 add-more-dis pull-right">+ Add More</a>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card-box">
                                        <div class="form-group mb-3">
                                            <label for="product">{{__('messages.product_list')}} <span class="text-danger">*</span></label>
                                            <a href="javascript:void(0)" class="btn btn-success btn-xs form-button mt-0 add-new-item float-right">+</a>
                                            <select class="form-control select2" name="product[]">
                                                <option value="">{{__('messages.select_product')}}</option>
                                                @forelse(@$items as $item)
                                                    <option value="{{$item->id}}">{{$item->product_name}}</option>
                                                    @empty
                                                @endforelse
                                            </select>
                                            <div class="invalid-feedback" id="product_error" style="display:none;"></div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="labeling_status">{{__('messages.labeling_status')}} <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="labeling_status[]">
                                                <option value="">{{__('messages.select_labeling_status')}}</option>
<<<<<<< HEAD
                                                @forelse($labelingStatus as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                    @empty
                                                @endforelse
=======
                                                @foreach($labelingStatus as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                @endforeach
>>>>>>> ca5061d62b03a89dbaada56d31483d73021663ef
                                            </select>
                                            <div class="invalid-feedback" id="labeling_status_error" style="display:none;"></div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="reg_work_inst">{{__('messages.reg_work_inst')}} <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="reg_work_inst[][]" multiple>
                                                <option value="">------</option>
<<<<<<< HEAD
                                                @forelse($workInstructions as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                    @empty
                                                @endforelse
=======
                                                @foreach($workInstructions as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                @endforeach
>>>>>>> ca5061d62b03a89dbaada56d31483d73021663ef
                                            </select>
                                            <div class="invalid-feedback" id="reg_work_inst_error" style="display:none;"></div>
                                        </div>
                                    </div> <!-- end card-box -->
                                </div> <!-- end col -->
                                <div class="col-lg-6">
                                    <div class="card-box">
                                        <div class="form-group mb-3">
                                            <label for="warehouse_qty">{{__('messages.warehouse_qty')}} <span class="text-danger">*</span></label>
                                            <input type="number" name="warehouse_qty[]" class="form-control">
                                            <div class="invalid-feedback" id="warehouse_qty_error" style="display:none;"></div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="fnsku_not_req">{{__('messages.fnsku_not_req')}} <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="fnsku_not_req[]">
                                                <option value="">{{__('messages.select_fnsku')}}</option>
                                                <option value="必要">必要</option>
                                                <option value="不要">不要</option>
                                                <option value="不明">不明</option>
                                            </select>
                                            <div class="invalid-feedback" id="fnsku_not_req_error" style="display:none;"></div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="ireg_work_inst">{{__('messages.ireg_work_inst')}}</label>
                                            <textarea name="ireg_work_inst[]" class="form-control"></textarea>
                                            <div class="invalid-feedback" id="ireg_work_inst_error" style="display:none;"></div>
                                        </div>
                                    </div>
                                </div> <!-- end col-->
                            </div>
                        </div>
                        <div class="dis-clone-here">

                        </div>
                    </div>
                    <div class="tab-pane" id="attachments">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box"> 
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.upload_invoice')}}</h5>
                                    <div class="form-group mb-3 invoice-file">
                                        <input type="file" name="invoice[]" class="dropify invoice" data-max-file-size="1M" multiple/>
                                        <div class="invalid-feedback" id="invoice_error" style="display:none;"></div>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.upload_invoice')}}</p>
                                    </div> 
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.packing_list')}}</h5>   
                                    <div class="form-group mb-3 packing-file">
                                        <input type="file" name="packing[]" class="dropify packing" data-max-file-size="1M" multiple/>
                                        <div class="invalid-feedback" id="packing_error" style="display:none;"></div>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.packing_list')}}</p>
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end col-->
                            <div class="col-lg-6">
                                <div class="card-box">  
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.bl')}}</h5>   
                                    <div class="form-group mb-3 bl-file">
                                        <input type="file" name="bl[]" class="dropify bl" data-max-file-size="1M" multiple/>
                                        <div class="invalid-feedback" id="bl_error" style="display:none;"></div>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.bl')}}</p>
                                    </div>
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.an')}}</h5>
                                    <div class="form-group mb-3 an-file">
                                        <input type="file" name="an[]" class="dropify an" data-max-file-size="1M" multiple/>
                                        <div class="invalid-feedback" id="an_error" style="display:none;"></div>
                                        <p class="text-muted text-center mt-2 mb-0">{{__('messages.an')}}</p>
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
                <button class="btn w-sm btn-success waves-effect waves-light saveWdata">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.wdata.index')}}" class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
<!-- end row -->
    @section('additional-content')
        @include('admin.warehouse.data.add-client')
        @include('admin.warehouse.data.add-item')
    @endsection
    @section('additional-js')
       <!-- Select2 js-->
        <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
        <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
        <!-- Dropzone file uploads-->
        <script src="{{asset('admin')}}/libs/dropzone/dropzone.min.js"></script>
        <script src="{{asset('admin')}}/libs/dropify/dropify.min.js"></script>
        <script src="{{asset('admin')}}/libs/datetimepicker/moment.min.js" type="text/javascript"></script>
        <script src="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="{{asset('admin')}}/libs/tippy-js/tippy.all.min.js"></script>
        <script src="{{asset('admin/custom/js/warehouse.js')}}"></script>
        <script>
            $(document).ready(function(){
                $(".add-more-dis").click(function (e) {
                    e.preventDefault();
                    var $dis = $("#dis-clone").html();
                    $('.dis-clone-here').append('<div class="row-0">'+$dis+'</div>');
                    $(".dis-clone-here .btn-secondary").removeClass("btn-success add-more-dis").addClass("btn-danger remove-clone");
                    $(".dis-clone-here .btn-secondary").text("- Remove");
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
                            thisRef.parent().remove();
                            $('.dis-clone-here').find('.dis-clone').each(function(index, val){
                                index++;
                                $(this).attr('id', 'clone-'+index);
                                $(this).find('.error-message').empty().hide();
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
@endsection