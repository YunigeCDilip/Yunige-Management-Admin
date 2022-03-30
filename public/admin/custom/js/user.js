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


    $('form#editForm').find('.change-password').on('click', function(e){
        e.preventDefault();
        $('#change-pass').find('.form-control').each(function(){
            if($('#change-pass').hasClass('collapse show')){
                $(this).prop("disabled", true);
                $('#change-pass').removeClass("change-pass");
            }else{
                $(this).prop("disabled", false);
                $('#change-pass').addClass("change-pass");
            }
        });
    });

    $('.save-user').on('click', function(e){
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
            url: baseUrl + "users",
            data: form_data,
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

    var editForm = $('form#editForm');
    $('.update-user').on('click', function(e){
        e.preventDefault();
        editForm.find('.invalid-feedback').each(function(){
            $(this).empty().hide();
        });
        var Id = editForm.find('input[name="user_id"]').val();
        $(this).prop('disabled', true);
        $(this).parents('.form-group').find('.spinner-border').show();
        var thisReference = $(this);
        var form_data = editForm.serializeArray();
        $.ajax({
            type: "POST",
            url: baseUrl + "users/"+Id,
            data: form_data,
            success: function(data){
                messages(data.message, data.status);
                if(data.status){
                    window.location = data.url;
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
});
var userTable;
$(function(){
    userTable = $('#table').DataTable({
        order: [0, 'desc'],
        dom: 'lfrtip',
        lengthMenu: [ 10, 25, 50, 100, 200, 500],
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
            url: baseUrl + 'users',
            type: "GET",
            dataType: 'json',

            'data': function (data) {
                data._token = csrfToken;
            },
            error: function (error) {
                console.log(error);
            }
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-id', data.userId);
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'email'},
            {data: 'role',
                render: function(data, type, dataObject, meta) {
                    return '<span class="badge badge-success">'+dataObject.role+'</span>';
                }
            },
            {data: 'active_status',
                render: function(data, type, dataObject, meta) {
                    if(data){
                        return '<span class="badge badge-success">Active</span>';
                    }else{
                        return '<span class="badge badge-danger">InActive</span>';
                    }
                }
            },
            {data: 'created_at'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    if(dataObject.manage_permission){
                        action += '<a href="'+baseUrl+'users/'+dataObject.userId+'/edit" class="action-icon" title="EDIT"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
                        if(dataObject.active_status){
                            action += '<a href="javascript:void(0)" class="action-icon activate" title="DEACTIVATE" data-status="0" data-id="'+dataObject.userId+'"> <i class="fe-power text-success"></i></a>';
                        }else{
                            action += '<a href="javascript:void(0)" class="action-icon activate" title="ACTIVATE" data-status="1" data-id="'+dataObject.userId+'"> <i class="fe-check-circle text-success"></i></a>';
                        }
                    }

                    if(!dataObject.is_auth_user){
                        if(dataObject.manage_permission){
                            action += '<a href="javascript:void(0);" class="action-icon" title="DELETE"> <i class="mdi mdi-delete text-danger" data-id="'+dataObject.userId+'"></i></a>';
                        }
                    }
                    return action;
                }
            }
        ],
    });
});

$('.custom-select').on('change', function () {
    $('body').find('#table_length select').val($(this).val()).trigger('change');
});

$('#searchForm').keyup(function(){
    $('body').find('#table_filter input').val($(this).val()).trigger('keyup');
});

$('table#table').delegate('.mdi-delete', 'click', function(e){
    e.preventDefault();
    var userId = $(this).attr('data-id');
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
                url: baseUrl + 'users/' + userId,
                type: 'post',
                data:{ id:userId, _method: 'DELETE', _token: csrfToken
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
                                userTable.draw();
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

$('table#table').delegate('.activate', 'click', function(e){
    e.preventDefault();
    var userId = $(this).attr('data-id');
    var status = $(this).attr('data-status');
    swal({
        title: "Are you sure want to update this data?",
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
                url: baseUrl + 'users/activate',
                type: 'post',
                data:{ id:userId, _token: csrfToken, status:status
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
                                userTable.draw();
                            }
                        });
                    }else{
                        swal("Not Updated", data.message, "error");
                    }
                },
                error: function(){},
            });
        }else{
            swal("Not Updated", "Data not Updated. it is save.", "error");
        }
    });
});