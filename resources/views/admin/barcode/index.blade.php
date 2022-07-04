@extends('layouts.layout')
@section('additional-css')
<link href="{{asset('admin/custom/css/barcode.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row qr-section" id="app" @click="focusInput($event)" v-cloak>
    <div class="col-12">
        <input type="text" id="qrcode-input" class="form-control" v-model="qrData"  @keyup.prevent="qrcodeDetected" disabled>
        <div class="text-center">
            <i class="h1 mdi mdi mdi-barcode-scan text-muted"></i>
            <h3 class="mb-3">Read Barcode Frequently !!!</h3>
            <p class="text-muted"> A barcode reader, also called a price scanner or point-of-sale ( POS ) scanner,
            is a hand-held or stationary input device used to capture and<br> and read information contained in a bar code .!</p>

        </div>
        <div class="row" v-if="items.length">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-right">
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-blue btn-xs" @click.prevent=exportBarcodeReports(1)><i class="mdi mdi-truck-delivery mr-1"></i> Generate Outbounds</button>
                                    </div>
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-success btn-xs" @click.prevent=exportBarcodeReports(1)><i class=" mdi mdi-file-excel mr-1"></i> Export xlxs</button>
                                    </div>
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-secondary btn-xs" @click.prevent=exportBarcodeReports(0)><i class="mdi mdi-file-pdf mr-1"></i> Export pdf</button>
                                    </div>
                                </div>
                            </div><!-- end col-->
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Item Name</th>
                                    <th>Barcode</th>
                                    <th>Readings</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in items">
                                        <td>
                                        <template v-if="item.images.length">
                                            <template v-for="image in item.images">
                                                <a :href="image.url" target="_blank"><img :src="image.url" alt="" height="15"></a>
                                            </template>
                                        </template>
                                        </td>
                                        <td>@{{ item.name }}</td>
                                        <td>@{{ item.barcode }}</td>
                                        <td>
                                            <input type="text" readonly :value="item.quantity" style="width: 50px;border: outset;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <ul class="pagination pagination-rounded justify-content-end mb-0" v-if="pagination.last_page != 1">
                            <li class="page-item">
                                <template v-if="pagination.current_page == 1">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </template>
                                <template v-else>
                                    <a class="page-link" href="javascript: void(0);" 
                                        aria-label="Previous"
                                        @click.prevent="paginate(pagination.first_page_url)">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </template>
                            </li>
                            <li class="page-item">
                                <template v-if="pagination.current_page == pagination.last_page">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </template>
                                <template v-else>
                                    <a class="page-link" href="javascript: void(0);"
                                        aria-label="Next"
                                        @click.prevent="paginate(pagination.next_page_url)">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </template>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="message-alert text-center" id="fail-message" style="display: none;">
            <div class="message-box">
                <a href="javascript:void(0);" class="btn-close" v-on:click="closeMessage">&times</a>
                <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;">
                    <span class="swal2-x-mark">
                        <span class="swal2-x-mark-line-left"></span>
                        <span class="swal2-x-mark-line-right"></span>
                    </span>
                </div>
                <p class="text-danger"></p>
                <h4 id="message"></h4>
            </div>
        </div>
          
    </div><!-- end col -->
</div>
@endsection
@section('additional-js')
    <script src="{{ asset('admin/libs') }}/axios/vue.js"></script>
    <script src="{{ asset('admin/libs') }}/axios/axios.min.js"></script>
    <script src="{{ asset('admin/libs') }}/lodash/lodash.min.js"></script>
    <script src="{{ asset('admin/custom') }}/js/barcode.js"></script>
@endsection