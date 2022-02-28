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
});

var userTable = $('#table').DataTable({
    order: [0, 'desc'],
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
                    action += '<a href="'+baseUrl+'users/'+dataObject.id+'/edit" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                }

                if(!dataObject.is_auth_user){
                    if(dataObject.manage_permission){
                        action += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete" data-id="'+dataObject.id+'"></i></a>';
                    }
                }
                return action;
            }
        }
    ],
});

$('.custom-select').on('change', function () {
    $('body').find('#table_length select').val($(this).val()).trigger('change');
});

$('#searchForm').keyup(function(){
    $('body').find('#table_filter input').val($(this).val()).trigger('keyup');
});

var addForm = $('form#addForm');
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

$('table#table').delegate('.mdi-delete', 'click', function(e){
    e.preventDefault();
    var userId = $(this).attr('data-id');
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
                                thisReference.parents('tr').remove();
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