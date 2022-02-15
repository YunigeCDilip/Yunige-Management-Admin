/**
 * Created by Dilip Chaudhary.
 * Date: 2021.01.13
 */
$('.btn-login').on('click', function(e){
    e.preventDefault();
    $('.loader-container').show();
    var formData = $('form#loginForm').serializeArray();
    $.ajax({
        type: "POST",
        url: baseUrl + "login",
        data: formData,
        success: function(data){
            if(data.status == 'true'){
                window.location = data.url;
            }else{
                $('form#loginForm').find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                $('form#loginForm').find('.lg-error-top').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ data.message).show();
                $('.loader-container').hide();
            }
        },
        error: function(error){
            if( error.status === 422 && error.readyState == 4) {
                $('form#loginForm').find('.lg-error').each(function(){
                    $(this).empty().hide();
                });
                var errors = $.parseJSON(error.responseText);
                $.each(errors.errors, function (key, val) {
                    $('form#loginForm').find('#'+key+'_error').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ val).show();
                });
                $('.loader-container').hide();
            }
        },
    });
});

