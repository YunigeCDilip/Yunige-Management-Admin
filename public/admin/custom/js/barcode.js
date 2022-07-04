var vm = new Vue({
    el: "#app",
    data: function(){
        return{
            qrData: '',
            items: [],
            pagination: [],
            barcodes: [],
            barcodeIds: [],
            exportAll: false,
        }
    },
    mounted: function() {
        $('#qrcode-input').prop( "disabled", false);
        $('#qrcode-input').focus();

        $(".qr-section").click(function (e) {
            e.preventDefault();
            $( ".form-control" ).focus();
        });
        this.listBarcodeItems();
        this.methodProcessor();
    },
    methods: {
        paginate: function(url){
            let thisReference = this;
            axios.post(url, {})
                .then(function(response) {
                    thisReference.items = response.data.payload;
                    thisReference.pagination = response.data.meta_data.pagination;

                }).catch(function(error) {
                });
        },
        methodProcessor: function(){
            let thisReference = this;
            thisReference.barcodes = JSON.parse(localStorage.getItem('barcodes'));
            if(thisReference.barcodes.length > 0){
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
        focusInput: function(e){
            e.preventDefault();
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
                    thisReference.pagination = response.data.meta_data.pagination;

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

        },200),
        exportBarcodeReports: function(type){
            let thisReference = this;
            thisReference.items.map(function(v,i){
                thisReference.barcodeIds.push(v.id);
            });

            var searchFormData = {
                    ids: thisReference.barcodeIds,
                }
            if(type == 1){
                var url = baseUrl + "barcodes/excel-export?"+  $.param(searchFormData);

            }else{
                var url = baseUrl + "barcodes/pdf-export?"+  $.param(searchFormData);
            }
            window.location = url;
        }
    }
});