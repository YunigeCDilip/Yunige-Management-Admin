/**
 * Created by Dilip Chaudhary.
 * Date: 2022.02.13
 */
 $('.btn-register').on('click', function(e){
    e.preventDefault();
    $('form#registerForm').find('.invalid-feedback').each(function(){
        $(this).empty().hide();
    });
    $(this).prop('disabled', true);
    $(this).parents('.form-group').find('.spinner-border').show();
    var thisReference = $(this);
    var formData = $('form#registerForm').serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "register",
        data: formData,
        success: function(data){
            thisReference.parents('.form-group').find('.spinner-border').hide();
            thisReference.prop('disabled', false);
            $('form#loginForm').find('.lg-error').each(function(){
                $(this).empty().hide();
            });
            if(data.status){
                $('form#registerForm')[0].reset();
                $('.success-message').empty().append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+ data.message).show();
            }else{
                $('.error-message').empty().append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+ data.message).show();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                $('form#registerForm').find('.invalid-feedback').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.message, function (key, val) {
                    $('form#registerForm').find('input[name="'+key+'"]').attr('required', 'required');
                    $('form#registerForm').find('#' + key + '_error').empty().append(val);
                    $('form#registerForm').find('#' + key + '_error').show();
                });
                thisReference.parents('.form-group').find('.spinner-border').hide();
                thisReference.prop('disabled', false);
            }

            $('form#registerForm').addClass('was-validated');
        },
    });
});

