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
            default:"Drag and drop a images here",
            replace:"Drag and drop or click to replace",
            remove:"Remove",
            error:"Ooops, something wrong appended."
        },
        error:{
            fileSize:"The file size is too big (1M max)."
        }
    });

    });
    $('#datetimepicker').datetimepicker({
        "allowInputToggle": true,
        "showClose": true,
        "showClear": true,
        "showTodayButton": true,
        "format": "YYYY-MM-DD",
    });
    $('#datetimepicker1').datetimepicker({
        "allowInputToggle": true,
        "showClose": true,
        "showClear": true,
        "showTodayButton": true,
        "format": "YYYY-MM-DD",
});

var table;
$(function(){
    table = $("#table").DataTable({
        dom: 'lfrtip',
        order: [[0, 'desc']],
        lengthMenu: [25, 50, 100, 200, 500],
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
            url: baseUrl + 'sdata',
            type: "GET",
            dataType: 'json',
            'data': function (data) {
            
            },
            error: function (error) {
                console.log(error);
            }
        },
        columns: [
            {data: 'id', visible:false},
            {data: 'name'},
            {data: 'case_number'},
            {data: 'by_country'},
            {data: 'case_in_charge'},
            {data: 'matter_date'},
            {data: 'priority'},
            {data: 'ingredient_progress'},
            {data: 'notification_progress'},
            {data: 'sample_progress'},
            {data: 'label_creation_progress'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    action += '<a href="'+baseUrl+'sdata/'+dataObject.id+'" class="action-icon"> <i class="mdi mdi-eye text-success"></i></a>';
                    action += '<a href="'+baseUrl+'sdata/'+dataObject.id+'/edit" class="action-icon"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
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

$('.save-sdata').on('click', function(e){
    e.preventDefault();
    $('form#addForm').find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var form_data = $('form#addForm').serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "sdata",
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
                $('form#addForm').find('.form-control').each(function(){
                    $(this).prop('required', false);
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

var editForm = $('form#editForm');
$('.update-sdata').on('click', function(e){
    e.preventDefault();
    editForm.find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    var Id = editForm.find('input[name="sdata_id"]').val();
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var form_data = editForm.serializeArray();
    $.ajax({
        type: "PUT",
        url: baseUrl + "sdata/"+Id,
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
    var sdataId = $(this).attr('data-id');
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
                url: baseUrl + 'sdata/' + sdataId,
                type: 'post',
                data:{ id:sdataId, _method: 'DELETE', _token: csrfToken
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