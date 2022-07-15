@extends('layouts.layout')
@section('additional-css')
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">

    <!-- Summernote css -->
    <link href="{{asset('admin')}}/libs/summernote/summernote-bs4.css" rel="stylesheet" />
@endsection
@section('content')
<div class="row">
    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card-box">
            <!-- Left sidebar -->
            @include('admin.email.partials.menu')
            <!-- End Left sidebar -->

            <div class="inbox-rightbar">

                <div class="btn-group">
                    New Email
                </div>

                <div class="mt-4">
                    <form id="mailForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <select name="designation" class="form-control selectd">
                                <option value="">Select Designation</option>
                                @forelse($designations as $d)
                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                    @empty
                                @endforelse 
                            </select>
                            <div class="invalid-feedback" id="designation_error" style="display:none;"></div>
                        </div>
                        <div class="form-group">
                            <select name="user[]" class="form-control select2" multiple>
                                @forelse($users as $u)
                                    <option value="{{$u->id}}">{{$u->name}}</option>
                                    @empty
                                @endforelse 
                            </select>
                            <div class="invalid-feedback" id="user_error" style="display:none;"></div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Subject" name="subject">
                            <div class="invalid-feedback" id="subject_error" style="display:none;"></div>
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control summernote"></textarea>
                        </div>

                        <div class="form-group m-b-0">
                            <div class="text-right">
                                <button type="button" class="btn btn-success waves-effect waves-light m-r-5 send-mail" title="Save as Draft" data-draft="1">
                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                                    <i class="mdi mdi-content-save-outline"></i>
                                </button>
                                <button class="btn btn-primary waves-effect waves-light send-mail"  data-draft="0"> 
                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                                    <span>Send</span> <i class="mdi mdi-send ml-2"></i> 
                                </button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-->
            </div> 
            <!-- end inbox-rightbar-->

            <div class="clearfix"></div>
        </div> <!-- end card-box -->

    </div> <!-- end Col -->
</div><!-- End row -->
@endsection
@section('additional-js')
    <script src="{{asset('admin')}}/libs/select2/select2.min.js"></script>
    <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>

    <!--Summernote js-->
    <script src="{{asset('admin')}}/libs/summernote/summernote-bs4.min.js"></script>

    <script>
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
            $('.select2').select2({
                placeholder: "Select Users"
            });
            $('.selectd').select2({
                placeholder: "Select Designations"
            });
            $('.summernote').summernote({
                height: 230,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });
        });

        var mailForm = $('form#mailForm');

        mailForm.find('select[name="designation"]').change(function(e){
            e.preventDefault();
            var designationId = $(this).find(":selected").val();
            $.get(baseUrl+'get-users/'+designationId, function(response){
                if(response.status){
                    var html= '';
                    $.each(response.payload, function(i, v){
                        html += '<option value="'+v.id+'">'+v.name+'</option>';
                    });

                    mailForm.find('select[name="user[]"]').empty().append(html);
                }
            });
        });
        $('.send-mail').on('click', function(e){
            e.preventDefault();
            var draft = $(this).attr('data-draft');
            mailForm.find('.invalid-feedback').each(function(){
                $(this).empty().hide();
            });
            $(this).prop('disabled', true);
            $(this).find('.spinner-border').show();
            var thisReference = $(this);
            var form_data = new FormData();
            var add_Form = mailForm.serializeArray();
            console.log(add_Form);
            form_data.append('draft', draft);
            $.each(add_Form, function(key, val){
                form_data.append(val.name, val.value);
            });
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: baseUrl + "emails",
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data){
                    thisReference.prop('disabled', false);
                    thisReference.find('.spinner-border').hide();
                    messages(data.message, data.status);
                    if(data.status){
                        setTimeout(function(){
                            window.location = data.url;
                        }, 2000);
                    }else{
                        thisReference.find('.spinner-border').hide();
                        thisReference.prop('disabled', false);
                        mailForm.find('.lg-error').each(function(){
                            $(this).empty().hide();
                        });
                        mailForm.find('.lg-error-top').empty().append('<span class="error-icon"><i class="fas fa-exclamation-triangle"></i></span> '+ data.message).show();
                    }
                },
                error: function(error){
                    if( error.status === 422 && error.readyState == 4) {      
                        mailForm.find('.invalid-feedback').each(function(){
                            $(this).empty().hide();
                        });
                        var errors = $.parseJSON(error.responseText);
                        $.each(errors.message, function (key, val) {
                            mailForm.find('input[name="'+key+'"]').attr('required', 'required');
                            mailForm.find('#' + key + '_error').empty().append(val);
                            mailForm.find('#' + key + '_error').show();
                        });
                        thisReference.find('.spinner-border').hide();
                        thisReference.prop('disabled', false);
                    }

                    mailForm.addClass('was-validated');
                },
            });
        });

    </script>
@endsection