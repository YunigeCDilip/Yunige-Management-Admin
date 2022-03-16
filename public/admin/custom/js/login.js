/**
 * Created by Dilip Chaudhary.
 * Date: 2022.02.13
 */
$('.btn-login').on('click', function(e){
    e.preventDefault();
    $('form#loginForm').find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var formData = $('form#loginForm').serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "login",
        data: formData,
        success: function(data){
            if(data.status == 'true'){
                window.location = data.url;
            }else{
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
                $('form#loginForm').find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                $('.message').empty().append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+ data.message).show();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                $('form#loginForm').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    $('form#loginForm').find('input[name="'+key+'"]').attr('required', 'required');
                    $('form#loginForm').find('#' + key + '_error').empty().append(val);
                    $('form#loginForm').find('#' + key + '_error').show();
                });
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
            }

            $('form#loginForm').addClass('was-validated');
        },
    });
});

