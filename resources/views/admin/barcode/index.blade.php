@extends('layouts.layout')
@section('additional-css')
<style>
    /**/
    #fail-message .message-box{
    border: 2px solid #dc3545 ;
    }
    #success-message .message-box{
    border: 2px solid green;
    }
    .message-alert {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
    }

    .message-bg {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        transition: 400ms ease;
        transform: scale(0);
    }

    .active-animation .message-bg {
        transform: scale(1);
    }

    .message-box {
        padding: 45px 30px 30px;
        background-color: #fff;
        position: fixed;
        left: 60%;
        top: 50%;
        width: 50%;
        transform: translate(-50%, -50%);
        border-radius: 30px;
    }

    .btn-close {
        position: absolute;
        right: -10px;
        top: -10px;
        width: 35px;
        height: 35px;
        background-color: #4d4d4d;
        border-radius: 50%;
        line-height: 38px;
        font-size: 34px;
        color: #fff;
        box-shadow: -5px 5px 5px 0px rgba(0, 0, 0, .2);
    }

    /* Check */
    .success-checkmark {
        width: 80px;
        height: 115px;
        margin: 0 auto;
    }

    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4caf50;
    }

    .check-icon:before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .check-icon:after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }

    .check-icon:before,
    .check-icon:after {
        content: "";
        height: 100px;
        position: absolute;
        background: #ffffff;
        transform: rotate(-45deg);
    }

    .icon-line {
        height: 5px;
        background-color: #4caf50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }

    .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }

    .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(76, 175, 80, 0.5);
    }

    .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #ffffff;
    }

    @keyframes rotate-circle {
        0% {
            transform: rotate(-45deg);
        }

        5% {
            transform: rotate(-45deg);
        }

        12% {
            transform: rotate(-405deg);
        }

        100% {
            transform: rotate(-405deg);
        }
    }

    @keyframes icon-line-tip {
        0% {
            width: 0;
            left: 1px;
            top: 19px;
        }

        54% {
            width: 0;
            left: 1px;
            top: 19px;
        }

        70% {
            width: 50px;
            left: -8px;
            top: 37px;
        }

        84% {
            width: 17px;
            left: 21px;
            top: 48px;
        }

        100% {
            width: 25px;
            left: 14px;
            top: 45px;
        }
    }

    @keyframes icon-line-long {
        0% {
            width: 0;
            right: 46px;
            top: 54px;
        }

        65% {
            width: 0;
            right: 46px;
            top: 54px;
        }

        84% {
            width: 55px;
            right: 0px;
            top: 35px;
        }

        100% {
            width: 47px;
            right: 8px;
            top: 38px;
        }
    }

    /* Error */
    .swal2-icon {
        position: relative;
        justify-content: center;
        width: 5em;
        height: 5em;
        margin: 1.25em auto 1.875em;
        border: .25em solid transparent;
        border-radius: 50%;
        line-height: 5em;
        cursor: default;
        box-sizing: content-box;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        zoom: normal;
    }

    .swal2-icon.swal2-error {
        border-color: #f27474
    }

    .swal2-icon.swal2-error .swal2-x-mark {
        position: relative;
        flex-grow: 1
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
        display: block;
        position: absolute;
        top: 2.3125em;
        width: 2.9375em;
        height: .3125em;
        border-radius: .125em;
        background-color: #f27474
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
        left: 1.0625em;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg)
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
        right: 1em;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
    }

    .swal2-animate-error-icon {
        -webkit-animation: swal2-animate-error-icon .5s;
        animation: swal2-animate-error-icon .5s
    }

    @keyframes swal2-animate-error-icon {
        0% {
            -webkit-transform: rotateX(100deg);
            transform: rotateX(100deg);
            opacity: 0
        }

        100% {
            -webkit-transform: rotateX(0);
            transform: rotateX(0);
            opacity: 1
        }
    }

    .swal2-animate-error-icon .swal2-x-mark {
        -webkit-animation: swal2-animate-error-x-mark .5s;
        animation: swal2-animate-error-x-mark .5s
    }

    @keyframes swal2-animate-error-x-mark {
        0% {
            margin-top: 1.625em;
            -webkit-transform: scale(.4);
            transform: scale(.4);
            opacity: 0
        }

        50% {
            margin-top: 1.625em;
            -webkit-transform: scale(.4);
            transform: scale(.4);
            opacity: 0
        }

        80% {
            margin-top: -.375em;
            -webkit-transform: scale(1.15);
            transform: scale(1.15)
        }

        100% {
            margin-top: 0;
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1
        }
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
        top: .875em;
        width: 1.375em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
        left: .3125em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
        right: .3125em
    }

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
    [v-cloak] {display: none}

    .jq-toast-wrap {
        width: 400px !important;
        left: 78% !important;
        bottom: 60% !important;
    }
</style>
@endsection
@section('content')
<div class="row qr-section" id="app" v-on:click="focusInput" v-cloak>
    <div class="col-12">
        <input type="text" id="qrcode-input" class="form-control" v-model="qrData"  @keyup.prevent="qrcodeDetected" disabled>
        <div class="text-center">
            <i class="h1 mdi mdi mdi-barcode-scan text-muted"></i>
            <h3 class="mb-3">Read Barcode Frequently !!!</h3>
            <p class="text-muted"> A barcode reader, also called a price scanner or point-of-sale ( POS ) scanner,
            is a hand-held or stationary input device used to capture and<br> and read information contained in a bar code .!</p>

        </div>
        <div class="row">
            <div class="col-xl-12 order-xl-1 order-2" v-if="items.length">
                <div class="card-box mb-2" v-for="item in items">
                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mt-0 mb-2 font-16">@{{ item.name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center my-3 my-sm-0">
                                <template v-if="item.images.length">
                                    <template v-for="image in item.images">
                                        <a :href="image.url" target="_blank"><img :src="image.url" alt="" height="50"></a>
                                    </template>
                                </template>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-center my-3 my-sm-0">
                                <p class="mb-0">@{{ item.barcode }}</p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-center my-3 my-sm-0">
                            <input type="text" readonly :value="item.quantity" style="width: 50px;border: outset;">
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end card-box-->
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
    <script>
        var vm = new Vue({
            el: "#app",
            data: function(){
                return{
                    qrData: '',
                    items: [],
                    barcodes: []
                }
            },
            mounted: function() {
                $('#qrcode-input').prop( "disabled", false);
                $('#qrcode-input').focus();

                $(".qr-section").click(function () {
                    $( ".form-control" ).focus();
                });
                this.listBarcodeItems();
                this.methodProcessor();
            },
            methods: {
                methodProcessor: function(){
                    let thisReference = this;
                    thisReference.barcodes = JSON.parse(localStorage.getItem('barcodes'));
                    if(thisReference.barcodes.length > 0){
                        console.log(thisReference.barcodes.length -1, thisReference.barcodes[thisReference.barcodes.length -1]);
                        thisReference.verifyItems(thisReference.barcodes.length -1, thisReference.barcodes[thisReference.barcodes.length -1]);
                    }
                },
                closeMessage: function(type){
                    $('.message-alert').hide(500);
                    $('#qrcode-input').prop( "disabled", false);
                    $('#qrcode-input').focus();
                    let thisReference = this;
                    thisReference.methodProcessor();
                },
                focusInput: function(){
                    $('#qrcode-input').prop( "disabled", false);
                    $('#qrcode-input').focus();
                    
                    $(".qr-section").click(function () {
                        $( ".form-control" ).focus();
                    });
                },
                listBarcodeItems: function(){
                    let thisReference = this;
                    axios.post(baseUrl + 'barcodes', {})
                        .then(function(response) {
                            thisReference.items = response.data.payload;

                        }).catch(function(error) {
                        });
                },
                verifyItems: function(i, v){
                    let thisReference = this;
                    thisReference.barcodes.splice(i, 1);
                    localStorage.setItem('barcodes', JSON.stringify(thisReference.barcodes));
                    if(v === "") return false;
                    axios.post(baseUrl + 'verify-items', {barcode: v})
                    .then(function(response) {
                        if(response.data.status) {
                            thisReference.qrData = '';
                            var message = 'Barcode : '+response.data.payload.barcode+' : '+response.data.payload.quantity;
                            !function(p){
                                "use strict";
                                var t=function(){};
                                t.prototype.send=function(t,i,o,e,n,a,s,r){
                                    a||(a=3e3),s||(s=1);
                                    var c={heading:t,text:i,position:o,loaderBg:e,icon:n,hideAfter:a,stack:s};
                                    r&&(c.showHideTransition=r),p.toast().reset("all"),p.toast(c)},
                                    p.NotificationApp=new t,p.NotificationApp.Constructor=t
                                }(window.jQuery),
                                function(i){
                                    i.NotificationApp.send(response.data.payload.name,message,"bottom-center","#5ba035","success");
                                    
                            }(window.jQuery);
                        } else{
                            thisReference.qrData = '';
                            $('#qrcode-input').prop( "disabled", true );
                            $("#fail-message").find(".text-danger").html('Invalid Barcode');
                            $("#fail-message").find("#message").html(response.data.message);
                            $("#fail-message").show(500);
                        }

                    }).catch(function(error) {
                        thisReference.qrData = '';
                        $('#qrcode-input').prop( "disabled", true );
                        $("#fail-message").find(".text-danger").html('Invalid Barcode');
                        $("#fail-message").find("#message").html(error.response.data.message);
                        $("#fail-message").show(500);
                    })
                },
                qrcodeDetected: _.debounce(function() {
                    $('#qrcode-input').blur();
                    let thisReference = this;
                    thisReference.barcodes.push(thisReference.qrData);
                    thisReference.qrData = '';
                    $('#qrcode-input').focus();
                    localStorage.setItem('barcodes', JSON.stringify(thisReference.barcodes));
                    thisReference.methodProcessor();

                },200)
            }
        });
    </script>
@endsection