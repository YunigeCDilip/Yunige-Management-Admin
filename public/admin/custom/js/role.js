function messages(message, type)
{
    !function(p, message, type){
        "use strict";
        var t=function(){};
        t.prototype.send=function(t,i,o,e,n,a,s,r){a||(a=3e3),s||(s=1);
        var c={heading:t,text:i,position:o,loaderBg:e,icon:n,hideAfter:a,stack:s};
        r&&(c.showHideTransition=r),p.toast().reset("all"),p.toast(c)},
        p.NotificationApp=new t,p.NotificationApp.Constructor=t}(window.jQuery),
        function(i, message, type){
            if(type){
                i.NotificationApp.send("Well Done!",message,"top-right","#5ba035","success");
            }else{
                i.NotificationApp.send("Oh snap!",message,"top-right","#bf441d","error")
            }
            
        }(window.jQuery);
}

$('.save-role').on('click', function(e){
    e.preventDefault();
    $('form#addRole').removeClass('was-validated');
    var form_data = $('form#addRole').serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "roles",
        data: form_data,
        success: function (data) {
            $('form#dddRole').find('.invalid-feedback').each(function(){
                $(this).empty().hide();
            });
            if (data.status) {
                $(".custom_modal").fadeOut(500);
            }

            messages(data.message, data.status);
        },
        error: function (error) {
            if (error.status === 422 && error.readyState == 4) {
                $('form#dddRole').find('.invalid-feedback').each(function(){
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