function messages(message, type)
{
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
            if(type){
                i.NotificationApp.send("Well Done!",message,"top-right","#5ba035","success");
            }else{
                i.NotificationApp.send("Oh snap!",message,"top-right","#bf441d","error")
            }
            
        }(window.jQuery);
}

jQuery(document).ready(function(){
    $(".select2").select2();
    $(".permit").dropify({
        messages:{
            default:"Drag and drop a permit here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
    $(".invoice").dropify({
        messages:{
            default:"Drag and drop a invoice here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
    $(".packing").dropify({
        messages:{
            default:"Drag and drop a packing lists here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
    $(".an").dropify({
        messages:{
            default:"Drag and drop a AN here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
    $(".bl").dropify({
        messages:{
            default:"Drag and drop a BL here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
    $(".do").dropify({
        messages:{
            default:"Drag and drop a DO here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
    $(".arrival_pic").dropify({
        messages:{
            default:"Drag and drop a Arrival Pic here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
});

$(document).ready(function() {
    var a = $("#table").DataTable({
        dom: 'lfrtip',
        serverSide: true,
        responsive: true,
        processing: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        "ajax": {
            url: baseUrl + 'wdata',
            type: "GET",
            dataType: 'json',
            'data': function (data) {
            
            },
            error: function (error) {
                console.log(error);
            }
        },
        columns: [
            {data: 'Name'},
            {data: 'clientName'},
            {data: 'permitNo'},
            {data: 'trkNo'},
            {data: 'country'},
            {data: 'deliver'},
            {data: 'cat',
                render: function(data, type, dataObject, meta) {
                    var html = '';
                    if(data != ''){
                        $.each(data, function(key, val){
                            html += '<span class="badge bg-soft-success text-success">'+val+'</span>';
                        });
                    }
                    return html
                }
            },
            {data: 'status'},
            {data: 'createdTime'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    action += '<a href="'+baseUrl+'wdata/'+dataObject.id+'" class="action-icon"> <i class="mdi mdi-eye text-success"></i></a>';
                    action += '<a href="'+baseUrl+'wdata/'+dataObject.id+'/edit" class="action-icon"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
                    action += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete text-danger" data-id="'+dataObject.id+'"></i></a>';
                    
                    return action;
                }
            }
        ],
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});


$('.custom-select').on('change', function () {
    $('body').find('#table_length select').val($(this).val()).trigger('change');
});

$('#searchForm').keyup(function(){
    $('body').find('#table_filter input').val($(this).val()).trigger('keyup');
});

var addForm = $('form#addForm');
$('.saveWdata').on('click', function(e){
    e.preventDefault();
    $('form#addForm').find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var form_data = new FormData();
    var invoices;
    var permits;
    addForm.find('.invoice-file').each(function(key, value){
        invoices = $(this).find('input[name="invoice[]"]')[0].files;
        for (var i = 0; i < invoices.length; ++i) {
            (typeof invoices[i] == 'undefined') ? '' : form_data.append('invoice['+i+']', invoices[i]);
        }
    });
    addForm.find('.permit-file').each(function(key, value){
        permits = $(this).find('input[name="permit[]"]')[0].files;
        for (var i = 0; i < permits.length; ++i) {
            (typeof permits[i] == 'undefined') ? '' : form_data.append('permit['+i+']', permits[i]);
        }
    });
    var add_Form = $('form#addForm').serializeArray();
    $.each(add_Form, function(key, val){
        form_data.append(val.name, val.value);
    });
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: baseUrl + "wdata",
        data: form_data,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data){
            messages(data.message, data.status);
            if(data.status){
                window.location = data.url;
            }else{
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
                $('form#addForm').find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                $('form#addForm').find('.lg-error-top').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ data.message).show();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                $('form#addForm').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    $('form#addForm').find('input[name="'+key+'"]').attr('required', 'required');
                    $('form#addForm').find('#' + key + '_error').empty().append(val);
                    $('form#addForm').find('#' + key + '_error').show();
                });
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
            }

            $('form#addForm').addClass('was-validated');
        },
    });
});

$('table#table').delegate('.mdi-delete', 'click', function(e){
    e.preventDefault();
    var wDataId = $(this).attr('data-id');
    var thisReference = $(this);
    swal({
        title: "Are you sure want to delete this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#136ba7",
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm){
        if(isConfirm){
            $.ajax({
                url: baseUrl + 'wdata/' + wDataId,
                type: 'post',
                data:{ id:wDataId, _method: 'DELETE', _token: csrfToken
                },
                success: function(data){
                    if(data.status){
                        swal({
                            title: data.message,
                            type: "success",
                            confirmButtonColor: "#136ba7",
                            confirmButtonText: "Ok",
                            closeOnConfirm: true,
                        }, function(isConfirm){
                            if(isConfirm){
                                location.reload();
                            }
                        });
                    }else{
                        swal("Not Deleted", data.message, "error");
                    }
                },
                error: function(){},
            });
        }else{
            swal("Not Deleted", "Data not Deleted. it is save.", "error");
        }
    });
});

var editForm = $('form#editForm');
$('.updateWdata').on('click', function(e){
    e.preventDefault();
    var Id = $('form#editForm').find('input[name="wdata_id"]').val();
    $('form#editForm').find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var form_data = new FormData();
    var invoices;
    var permits;
    var packings;
    var an;
    var bl;
    var delivery;
    var arrivals;
    editForm.find('.invoice-file').each(function(key, value){
        invoices = $(this).find('input[name="invoice[]"]')[0].files;
        for (var i = 0; i < invoices.length; ++i) {
            (typeof invoices[i] == 'undefined') ? '' : form_data.append('invoice['+i+']', invoices[i]);
        }
    });
    editForm.find('.permit-file').each(function(key, value){
        permits = $(this).find('input[name="permit[]"]')[0].files;
        for (var i = 0; i < permits.length; ++i) {
            (typeof permits[i] == 'undefined') ? '' : form_data.append('permit['+i+']', permits[i]);
        }
    });
    editForm.find('.packing-file').each(function(key, value){
        packings = $(this).find('input[name="packing[]"]')[0].files;
        for (var i = 0; i < packings.length; ++i) {
            (typeof packings[i] == 'undefined') ? '' : form_data.append('packing['+i+']', packings[i]);
        }
    });
    editForm.find('.an-file').each(function(key, value){
        an = $(this).find('input[name="an[]"]')[0].files;
        for (var i = 0; i < an.length; ++i) {
            (typeof an[i] == 'undefined') ? '' : form_data.append('AN['+i+']', an[i]);
        }
    });
    editForm.find('.bl-file').each(function(key, value){
        bl = $(this).find('input[name="bl[]"]')[0].files;
        for (var i = 0; i < bl.length; ++i) {
            (typeof bl[i] == 'undefined') ? '' : form_data.append('BL['+i+']', bl[i]);
        }
    });
    editForm.find('.do-file').each(function(key, value){
        delivery = $(this).find('input[name="do[]"]')[0].files;
        for (var i = 0; i < delivery.length; ++i) {
            (typeof delivery[i] == 'undefined') ? '' : form_data.append('DO['+i+']', delivery[i]);
        }
    });
    editForm.find('.arrival_pic-file').each(function(key, value){
        arrivals = $(this).find('input[name="arrival_pic[]"]')[0].files;
        for (var i = 0; i < arrivals.length; ++i) {
            (typeof arrivals[i] == 'undefined') ? '' : form_data.append('arrival_pic['+i+']', arrivals[i]);
        }
    });
    var edit_form = $('form#editForm').serializeArray();
    $.each(edit_form, function(key, val){
        form_data.append(val.name, val.value);
    });
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: baseUrl + "wdata/"+Id,
        data: form_data,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data){
            messages(data.message, data.status);
            if(data.status){
                window.location = data.url;
            }else{
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
                $('form#editForm').find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                $('form#editForm').find('.lg-error-top').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ data.message).show();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                $('form#editForm').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    $('form#editForm').find('input[name="'+key+'"]').attr('required', 'required');
                    $('form#editForm').find('#' + key + '_error').empty().append(val);
                    $('form#editForm').find('#' + key + '_error').show();
                });
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
            }

            $('form#editForm').addClass('was-validated');
        },
    });
});