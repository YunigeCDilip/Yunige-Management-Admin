@extends('layouts.layout')
@section('additional-css')
<style>
    .qr-section .form-control {
        font-weight: 300;
        width: 100%;
        height: 48px;
        border-radius: 48px;
        border: 0;
        pointer-events: auto;
        color: transparent;
        text-shadow: 0 0 0 #fff;
        background: transparent;
        outline: none;
        transform:scale(0);
    }
    .qr-section .form-control:focus{
        box-shadow: none;
    }
    .form-group {
        position: relative;
    }
</style>
@endsection
@section('content')
<div class="row qr-section" id="app" v-on:click=focusInput>
    <div class="col-12">
        <input type="text" id="qrcode-input" class="form-control" v-model="qrData"  @keyup.prevent="qrcodeDetected">
        <div class="text-center">
            <i class="h1 mdi mdi mdi-barcode-scan text-muted"></i>
            <h3 class="mb-3">Read Barcode Frequently !!!</h3>
            <p class="text-muted"> A barcode reader, also called a price scanner or point-of-sale ( POS ) scanner,
            is a hand-held or stationary input device used to capture and<br> and read information contained in a bar code .!</p>

            <button type="button" class="btn btn-success waves-effect waves-light mt-2 mr-1"><i class="mdi mdi-check-box-multiple-outline mr-1"></i> Checked Success</button>
            <button type="button" class="btn btn-danger waves-effect waves-light mt-2"><i class="mdi mdi-message-alert mr-1"></i> Checked Error</button>

        </div>
          
    </div><!-- end col -->


    <div class="message-alert text-center" id="fail-message" style="display: none;">
            <div class="message-box">
                <a href="javascript:void(0);" class="btn-close">&times</a>
                <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;">
                    <span class="swal2-x-mark">
                        <span class="swal2-x-mark-line-left"></span>
                        <span class="swal2-x-mark-line-right"></span>
                    </span>
                </div>
                <h3 class="text-danger">Failure Message</h3>
                <p id="message">Failure text if any should be displayed here</p>
            </div>
        </div>
        <div class="message-alert text-center" id="success-message" style="display: none;">
            <div class="message-box">
                <a href="javascript:void(0);" class="btn-close">&times</a>
                <div class="success-checkmark">
                    <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                    </div>
                </div>
                <h3 class="text-success">Success Message</h3>
                <p id="message">Success text if any should be displayed here</p>
            </div>
        </div>
</div>
@endsection
@section('additional-js')
    <script src="{{ asset('admin/libs') }}/axios/vue.js"></script>
    <script src="{{ asset('admin/libs') }}/axios/axios.min.js"></script>
    <script src="{{ asset('admin/libs') }}/lodash/lodash.min.js"></script>
    <script>
        var vm = new Vue({
            el: "#app",
            data: {
                qrData: '',
            },
            mounted: function() {
                $('#qrcode-input').focus();

                $(".qr-section").click(function () {
                    $( ".form-control" ).focus();
                });
                this.listBarcodeItems();
            },
            methods: {
                focusInput: function(){
                    $('#qrcode-input').focus();
                    
                    $(".qr-section").click(function () {
                        $( ".form-control" ).focus();
                    });
                },
                listBarcodeItems: function(){
                    axios.post(baseUrl + 'barcodes', {})
                        .then(function(response) {
                            console.log(response);

                        }).catch(function(error) {
                        });
                },
                qrcodeDetected: _.debounce(function() {
                    $('#qrcode-input').blur();
                    let thisReference = this;

                    axios.post(baseUrl + 'verify-items', {barcode: thisReference.qrData})
                        .then(function(response) {
                            if(response.data.status === "valid-user") {
                                var memberName = 'Welcome '+response.data.member['full_name'];
                                $("#success-message").find(".text-success").html(memberName);
                                $("#success-message").find("#message").html(response.data.message);
                                $("#success-message").addClass("active-animation").show();
                                setTimeout(function() {
                                    $("#success-message").hide();
                                    $('#qrcode-input').focus();
                                    thisReference.qrData = '';
                                },2000)
                            } else if(response.data.status === "invalid-user"){
                                $("#fail-message").find(".text-success").html('Invalid Member');
                                $("#fail-message").find("#message").html(response.data.message);
                                $("#fail-message").addClass("active-animation").show();
                                setTimeout(function() {
                                    $('#fail-message').hide();
                                    $('#qrcode-input').focus();
                                    thisReference.qrData = '';
                                },2000)
                            } else if(response.data.status === "not-paid-user"){
                                $("#fail-message").find(".text-success").html('Not Paid User');
                                $("#fail-message").find("#message").html(response.data.message);
                                $("#fail-message").addClass("active-animation").show();
                                setTimeout(function() {
                                    $('#fail-message').hide();
                                    $('#qrcode-input').focus();
                                    thisReference.qrData = '';
                                },5000)
                            }else{
                                $("#fail-message").find(".text-success").html('No Program');
                                $("#fail-message").find("#message").html(response.data.message);
                                $("#fail-message").addClass("active-animation").show();
                                setTimeout(function() {
                                    $('#fail-message').hide();
                                    $('#qrcode-input').focus();
                                    thisReference.qrData = '';
                                },2000)
                            }

                        }).catch(function(error) {
                            $("#fail-message").find(".text-success").html('Invalid Member');
                            $("#fail-message").find("#message").html(response.data.message);
                            $("#fail-message").addClass("active-animation").show();
                            setTimeout(function() {
                                $('#fail-message').hide();
                                $('#qrcode-input').focus();
                                thisReference.qrData = '';
                            },2000)
                            console.log(error);
                        })

                },500)
            }
        });
    </script>
@endsection