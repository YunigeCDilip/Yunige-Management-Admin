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
    $('.cancel-cat').on('click', function(e){
        e.preventDefault();
        Custombox.modal.close();
    })
});

jQuery(document).ready(function(){

    $('.save-cat').on('click', function(e){
        e.preventDefault(); 
        $('form#addForm').find('.invalid-feedback').each(function(){
            $(this).empty().hide();
        });
        $('form#addForm').removeClass('was-validated');
        var form_data = $('form#addForm').serializeArray();
        $.ajax({
            type: "POST",
            url: baseUrl + "delivers",
            data: form_data,
            success: function (data) {
                if (data.status) {
                    Custombox.modal.close();
                }
                messages(data.message, data.status);
                userTable.draw();
            },
            error: function (error) {
                if (error.status === 422 && error.readyState == 4) {
                    $('form#addForm').find('.invalid-feedback').each(function(){
                        $(this).empty().hide();
                    });
                    var errors = $.parseJSON(error.responseText);
                    $.each(errors.message, function (key, val) {
                        $('form#addForm').find('input[name="'+key+'"]').attr('required', 'required');
                        $('form#addForm').find('#' + key + '_error').empty().append(val);
                        $('form#addForm').find('#' + key + '_error').show();
                    });
                }
    
                $('form#addForm').addClass('was-validated');
            },
            complete: function(){
            }
        });
    });

    $('table#table').delegate('.mdi-square-edit-outline', 'click', function(e){
        var catId = $(this).attr('data-id');
        $.get(baseUrl+"delivers/"+catId, function(data){
            var form = $('form#editForm');
            if(data.status){
                form.find('input[name="category_id"]').val(catId);
                form.find('input[name="name"]').val(data.payload.name);
                form.find('select[name="status"] option[value="'+data.payload.active_status+'"]').prop('selected', true);
                var modal = new Custombox.modal({
                    content: {
                        effect: 'fadein',
                        target: '#edit-custom-modal'
                    },
                    overlay: {
                        close: false,
                    }
                });
                modal.open();
            }else{
                messages(data.message, data.status);
            }
        });
    });

    $('.update-cat').on('click', function(e){
        e.preventDefault();
        $('form#editForm').removeClass('was-validated');
        var form_data = $('form#editForm').serializeArray();
        $.ajax({
            type: "PUT",
            url: baseUrl + "delivers/"+$('form#editForm').find('input[name="category_id"]').val(),
            data: form_data,
            success: function (data) {
                $('form#editForm').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                if (data.status) {
                    Custombox.modal.close();
                }
                messages(data.message, data.status);
                userTable.draw();
            },
            error: function (error) {
                if (error.status === 422 && error.readyState == 4) {
                    $('form#editForm').find('.invalid-feedback').each(function(){
                        $(this).empty().hide();
                    });
                    var errors = $.parseJSON(error.responseText);
                    $.each(errors.message, function (key, val) {
                        $('form#editForm').find('input[name="'+key+'"]').attr('required', 'required');
                        $('form#editForm').find('#' + key + '_error').empty().append(val);
                        $('form#editForm').find('#' + key + '_error').show();
                    });
                }

                $('form#editForm').addClass('was-validated');
            },
            complete: function(){
            }
        });
    });
});
var userTable;
$(function(){
    userTable = $('#table').DataTable({
        order: [2, 'desc'],
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
            url: baseUrl + 'delivers',
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
            {data: 'name'},
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
                    action += '<a href="javascript:void(0);" class="action-icon" title="EDIT"> <i class="mdi mdi-square-edit-outline text-primary" data-id="'+dataObject.id+'"></i></a>';
                    if(dataObject.active_status){
                        action += '<a href="javascript:void(0)" class="action-icon activate" title="DEACTIVATE" data-status="0" data-id="'+dataObject.id+'"> <i class="fe-power text-success"></i></a>';
                    }else{
                        action += '<a href="javascript:void(0)" class="action-icon activate" title="ACTIVATE" data-status="1" data-id="'+dataObject.id+'"> <i class="fe-check-circle text-success"></i></a>';
                    }
                    action += '<a href="javascript:void(0);" class="action-icon" title="DELETE"> <i class="mdi mdi-delete text-danger" data-id="'+dataObject.id+'"></i></a>';
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
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm){
        if(isConfirm){
            $.ajax({
                url: baseUrl + 'delivers/' + userId,
                type: 'post',
                data:{ id:userId, _method: 'DELETE', _token: csrfToken
                },
                success: function(data){
                    userTable.draw();
                    messages(data.message, data.status);
                },
                error: function(){},
            });
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
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm){
        if(isConfirm){
            $.ajax({
                url: baseUrl + 'delivers/activate',
                type: 'post',
                data:{ id:userId, _token: csrfToken, status:status
                },
                success: function(data){
                    userTable.draw();
                    messages(data.message, data.status);
                },
                error: function(){},
            });
        }
    });
});