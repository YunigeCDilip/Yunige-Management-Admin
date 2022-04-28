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

$(function(){
    $(".select2").select2();
    $(".attachment").dropify({
        messages:{
            default:"Drag and drop a attachment here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });
});

var table;
$(function(){
    table = $("#table").DataTable({
        order: [ 5, 'desc' ],
        dom: 'lfrtip',
        lengthMenu: [ 25, 50, 100, 200, 500],
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
            url: baseUrl + 'custom-brokers',
            type: "GET",
            dataType: 'json',
            'data': function (data) {
            
            },
            error: function (error) {
                console.log(error);
            }
        },
        columns: [
            {data: 'name'},
            {data: 'wdata'},
            {data: 'email'},
            {data: 'telephone_no'},
            {data: 'fax_number'},
            {data: 'created_at'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    action += '<a href="'+baseUrl+'custom-brokers/'+dataObject.id+'" class="action-icon"> <i class="mdi mdi-eye text-success"></i></a>';
                    action += '<a href="'+baseUrl+'custom-brokers/'+dataObject.id+'/edit" class="action-icon"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
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
$('.save-data').on('click', function(e){
    e.preventDefault();
    addForm.find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var form_data = addForm.serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "custom-brokers",
        data: form_data,
        success: function(data){
            messages(data.message, data.status);
            if(data.status){
                setTimeout(function(){
                    window.location = data.url;
                }, 2000);
            }else{
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
                addForm.find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                addForm.find('.lg-error-top').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ data.message).show();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                addForm.find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                addForm.find('.form-control').each(function(){
                    $(this).prop('required', false);
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    addForm.find('input[name="'+key+'"]').attr('required', 'required');
                    addForm.find('#' + key + '_error').empty().append(val);
                    addForm.find('#' + key + '_error').show();
                });
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
            }

            addForm.addClass('was-validated');
        },
    });
});

var editForm = $('form#editForm');
$(document).on("click",".update-data", function (e){
    e.preventDefault();
    editForm.find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    var Id = editForm.find('input[name="broker_id"]').val();
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var form_data = editForm.serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "custom-brokers/"+Id,
        data: form_data,
        success: function(data){
            messages(data.message, data.status);
            if(data.status){
                setTimeout(function(){
                    window.location = data.url;
                }, 2000);
            }else{
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
                editForm.find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                editForm.find('.lg-error-top').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ data.message).show();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                editForm.find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    editForm.find('input[name="'+key+'"]').attr('required', 'required');
                    editForm.find('#' + key + '_error').empty().append(val);
                    editForm.find('#' + key + '_error').show();
                });
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
            }

            editForm.addClass('was-validated');
        },
    });
});


$('table#table').delegate('.mdi-delete', 'click', function(e){
    e.preventDefault();
    var clientId = $(this).attr('data-id');
    swal({
        title: "Are you sure want to delete this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#136ba7",
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm){
        if(isConfirm){
            $.ajax({
                url: baseUrl + 'custom-brokers/' + clientId,
                type: 'post',
                data:{ id:clientId, _method: 'DELETE', _token: csrfToken
                },
                success: function(data){
                    table.draw();
                    messages(data.message, data.status);
                },
                error: function(){},
            });
        }
    });
});