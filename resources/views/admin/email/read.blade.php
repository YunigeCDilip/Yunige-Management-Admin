@extends('layouts.layout')
@section('additional-css')
    <!-- Summernote css -->
    <link href="{{asset('admin')}}/libs/summernote/summernote-bs4.css" rel="stylesheet" />
    <style>
        [v-cloak] {display: none}
        .message-list li .col-mail-2 .date {
            width: 140px;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card-box" id="app" v-cloak>
            <!-- Left sidebar -->
            @include('admin.email.partials.menu')
            <!-- End Left sidebar -->
            <div class="inbox-rightbar">
                <div class="mt-4">
                    <h5 class="font-18">{{$message->subject}}</h5>
                    <hr/>

                    <div class="media mb-4 mt-1">
                        <div class="media-body">
                            <span class="float-right">{{$message->created_at}}</span>
                            <h6 class="m-0 font-14">{{$message->sender->name}}</h6>
                            <small class="text-muted">From: {{$message->sender->email}}</small>
                        </div>
                    </div>

                    {!! $message->message !!}

                    <hr/>
                </div> <!-- card-box -->
                @if($message->details)
                    @foreach($message->details as $detail)
                        <div class="mt-4">
                            <div class="media mb-4 mt-1">
                                <div class="media-body">
                                    <span class="float-right">{{date('M j, Y, h:i A', strtotime($detail->created_at))}}</span>
                                    <h6 class="m-0 font-14">{{$detail->sender->name}}</h6>
                                    <small class="text-muted">From: {{$detail->sender->email}}</small>
                                </div>
                            </div>
                            {!! $detail->message !!}
                            <hr/>
                        </div> <!-- card-box -->
                    @endforeach
                @endif
                @if(!$trashed)
                <form id="mailForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="message_id" value="{{$message->id}}">
                    <div class="media mb-0 mt-5">
                        <div class="media-body">
                            <div class="mb-2">
                                <textarea class="form-control summernote" name="message"></textarea> <!-- end summernote-->
                                <div class="invalid-feedback" id="message_error" style="display:none;"></div>
                            </div> <!-- end reply-box -->
                        </div> <!-- end media-body -->
                    </div> <!-- end medi-->

                    <div class="text-right">
                        <button type="button" class="btn btn-primary btn-rounded width-sm send-mail">
                        <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                        Send</button>
                    </div>
                </form>
                @endif
            </div> 
            <!-- end inbox-rightbar-->

            <div class="clearfix"></div>
        </div> <!-- end card-box -->

    </div> <!-- end Col -->
</div><!-- End row -->
@endsection
@section('additional-js')
    <script src="{{ asset('admin/libs') }}/axios/vue.js"></script>
    <script src="{{ asset('admin/libs') }}/axios/axios.min.js"></script>
    <script>
        var vm = new Vue({
            el: "#app",
            data: function(){
                return{
                    count: [],
                }
            },
            mounted: function() {
                this.countMessages();
            },
            methods: {
                countMessages: function(){
                    let thisReference = this;
                    axios.get(baseUrl + 'count-emails')
                        .then(function(response) {
                            thisReference.count = response.data.payload;

                        }).catch(function(error) {
                        });
                }
            }
        });
    </script>

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
            $('.summernote').summernote({
                height: 230,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });
        });

        var mailForm = $('form#mailForm');
        $('.send-mail').on('click', function(e){
            e.preventDefault();
            var id = mailForm.find('input[name="message_id"]').val();
            mailForm.find('.invalid-feedback').each(function(){
                $(this).empty().hide();
            });
            $(this).prop('disabled', true);
            $(this).find('.spinner-border').show();
            var thisReference = $(this);
            var form_data = new FormData();
            var add_Form = mailForm.serializeArray();
            $.each(add_Form, function(key, val){
                form_data.append(val.name, val.value);
            });
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: baseUrl + "emails/"+id,
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
                        $.each(errors.errors, function (key, val) {
                            mailForm.find('textarea[name="'+key+'"]').attr('required', 'required');
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