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
    $('.cancel-role').click(function(e){
        e.preventDefault();
        Custombox.modal.close();
    })
});

$('.save-role').on('click', function(e){
    e.preventDefault(); 
    $('form#addRole').find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $('form#addRole').removeClass('was-validated');
    var form_data = $('form#addRole').serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "roles",
        data: form_data,
        success: function (data) {
            if (data.status) {
                Custombox.modal.close();
            }
            messages(data.message, data.status);
            location.reload();
        },
        error: function (error) {
            if (error.status === 422 && error.readyState == 4) {
                $('form#addRole').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    $('form#addRole').find('input[name="'+key+'"]').attr('required', 'required');
                    $('form#addRole').find('#' + key + '_error').empty().append(val);
                    $('form#addRole').find('#' + key + '_error').show();
                });
            }

            $('form#addRole').addClass('was-validated');
        },
        complete: function(){
        }
    });
});

$('table#role-table').delegate('.edit-role', 'click', function(e){
    var roleId = $(this).parents('tr').attr('data-id');
    $.get(baseUrl+"roles/"+roleId+"/edit", function(role){
        var form = $('form#editRole');
        if(role.status){
            form.find('input[name="role_id"]').val(roleId);
            form.find('input[name="name"]').val(role.payload.name);
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

$('.update-role').on('click', function(e){
    e.preventDefault();
    $('form#editRole').removeClass('was-validated');
    var form_data = $('form#editRole').serializeArray();
    $.ajax({
        type: "PUT",
        url: baseUrl + "roles/"+$('form#editRole').find('input[name="role_id"]').val(),
        data: form_data,
        success: function (data) {
            $('form#editRole').find('.invalid-feedback').each(function(){
                $(this).empty().hide();
            });
            if (data.status) {
                Custombox.modal.close();
            }
            messages(data.message, data.status);
            location.reload();
        },
        error: function (error) {
            if (error.status === 422 && error.readyState == 4) {
                $('form#editRole').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    $('form#editRole').find('input[name="'+key+'"]').attr('required', 'required');
                    $('form#editRole').find('#' + key + '_error').empty().append(val);
                    $('form#editRole').find('#' + key + '_error').show();
                });
            }

            $('form#editRole').addClass('was-validated');
        },
        complete: function(){
        }
    });
});

/*========== END SCRIPT TO DELETE ROLE =================*/
$('table#role-table').delegate('.delete-role', 'click', function(e){
    e.preventDefault();
    var roleId = $(this).parents('tr').attr('data-id');
    var thisReference = $(this);
    swal({
        title: "Are you sure want to delete this role?",
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
                url: baseUrl + 'roles/' + roleId,
                type: 'post',
                data:{ id:roleId, _method: 'DELETE', _token: csrfToken
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
            swal("Not Deleted", "Role is not Deleted. it is save.", "error");
        }
    });
});
/*========== END SCRIPT TO DELETE ROLE =================*/