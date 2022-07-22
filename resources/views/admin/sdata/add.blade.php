@extends('layouts.layout')
@section('additional-css')
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
<link href="{{asset('admin')}}/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('admin')}}/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet"
    type="text/css" />
<style>
    .select2.select2-container {
        width: 100% !important;
    }

</style>

<form id="addForm" method="post" autocomplete="off" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="case_number">{{__('messages.case_number')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="case_number">
                        <option value="Fedex">アトゥル</option>
                        <option value="Yamato">アニール</option>
                        <option value="SellerShipment">カリナ</option>
                        <option value="SellerShipment">サリー</option>
                        <option value="SellerShipment">ベン</option>
                        <option value="SellerShipment">ラメシュ</option>
                        <option value="Fedex">下村</option>
                        <option value="Yamato">中谷</option>
                        <option value="SellerShipment">井上剣</option>
                        <option value="SellerShipment">井上智</option>
                        <option value="SellerShipment">今井</option>
                        <option value="SellerShipment">安</option>
                        <option value="SellerShipment">宋</option>
                        <option value="SellerShipment">山崎</option>
                        <option value="SellerShipment">岡本</option>
                        <option value="SellerShipment">岸本</option>
                        <option value="SellerShipment">崔</option>
                        <option value="SellerShipment">曲</option>
                        <option value="SellerShipment">杉生</option>
                        <option value="SellerShipment">李</option>
                        <option value="SellerShipment">村田</option>
                        <option value="SellerShipment">東本</option>
                        <option value="SellerShipment">梶村</option>
                        <option value="SellerShipment">深水</option>
                        <option value="SellerShipment">清水</option>
                        <option value="SellerShipment">網本</option>
                        <option value="SellerShipment">蔡松我</option>
                        <option value="SellerShipment">藤野</option>
                        <option value="SellerShipment">辻</option>
                        <option value="SellerShipment">阪根</option>
                        <option value="SellerShipment">馬</option>
                        <option value="SellerShipment">高津</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="matter_date">{{__('messages.matter_date')}}</label>
                    <input type="text" name="matter_date" class="form-control" id="datetimepicker" placeholder="">
                </div>


                <div class="form-group mb-3">
                    <label for="case_number">{{__('messages.priority')}} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="case_number">
                        <option value="Fedex">大至急</option>
                        <option value="Yamato">至急</option>
                        <option value="SellerShipment">通常</option>
                        <option value="SellerShipment">案件完了</option>
                        <option value="SellerShipment">案件NG</option>
                        <option value="SellerShipment">保留中</option>
                        <option value="Fedex">過去登録</option>
                        <option value="Yamato">音信不通</option>
                        <option value="SellerShipment">不明（雑貨？食品？）</option>

                    </select>
                </div>


                <div class="form-group mb-3">
                    <label for="name">{{__('messages.tracking_url')}} <span class="text-danger">*</span></label>
                    <input type="text" name="tracking_url" class="form-control" placeholder="tracking url">
                    <div class="invalid-feedback" id="tracking_url_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="by_country">{{__('messages.product_master')}} <span class="text-danger">*</span>
                    </label>
                    <select class="form-control select2" name="pproduct_types[]" multiple>
                        <option value="">{{__('messages.select_product_master')}}</option>
                        <option value="">{{__('messages.select_product_master')}}</option>
                    </select>
                </div>


                <div class="form-group mb-3">
                    <label for="case_in_charge">{{__('messages.ingredient_special_note')}} <span
                            class="text-danger">*</span></label>
                    <input type="text" name="ingredient_special_note" class="form-control" placeholder="case_in_charge">
                    <div class="invalid-feedback" id="ingredient_special_note_error" style="display:none;"></div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card-box">
                <div class="form-group mb-3">
                    <label for="ingredient_progress">{{__('messages.memo')}} <span class="text-danger">*</span></label>
                    <input type="text" name="memo" class="form-control" placeholder="memo">
                    <div class="invalid-feedback" id="memo_error" style="display:none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="ingredient_progress">{{__('messages.ingredient_progress')}} <span
                            class="text-danger">*</span></label>
                    <input type="text" name="ingredient_progress" class="form-control"
                        placeholder="ingredient_progress">
                    <div class="invalid-feedback" id="ingredient_progress_error" style="display:none;"></div>
                </div>

                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.attachments')}}</h5>
                <div class="form-group mb-3 attachment-file">
                    <input type="file" name="attachment[]" class="dropify attachment" data-max-file-size="1M"
                        multiple />
                    <p class="text-muted text-center mt-2 mb-0">{{__('messages.attachments')}}</p>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <button class="btn w-sm btn-success waves-effect waves-light save-sdata">
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"
                        style="display: none;"></span>
                    {{__('actions.save')}}
                </button>
                <a href="{{route('admin.sdata.index')}}"
                    class="btn w-sm btn-danger waves-effect">{{__('actions.cancel')}}</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('additional-js')
<!-- Dropzone file uploads-->
<script src="{{asset('admin')}}/libs/dropify/dropify.min.js"></script>
<!-- Select2 js-->
<script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
<script src="{{asset('admin')}}/libs/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
<script src="{{asset('admin')}}/libs/datetimepicker/moment.min.js" type="text/javascript"></script>
<script src="{{asset('admin')}}/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('admin/custom/js/sdata.js')}}"></script>
@endsection
