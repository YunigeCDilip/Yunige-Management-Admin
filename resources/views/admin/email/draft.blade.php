@extends('layouts.layout')
@section('additional-css')
    <link rel="stylesheet" href="{{asset('admin/libs/sweetalert/sweetalert.css')}}">
    <style>
        [v-cloak] {display: none}
        .message-list li .col-mail-2 .date {
            width: 140px;
        }

        .message-list li .col-mail-2 .subject {
            right: 170px;
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
                @include('admin.email.partials.actions')
                <template v-if="messages.length">
                    <div class="mt-3">
                        <ul class="message-list">
                            <template v-for="m in messages">
                                <li>
                                    <div class="col-mail col-mail-1">
                                        <div class="checkbox-wrapper-mail">
                                            <input type="checkbox" :id="m.id" v-model="message_ids" :value="m.id">
                                            <label :for="m.id" class="toggle"></label>
                                        </div>
                                        <span class="star-toggle far fa-star text-success"></span>
                                        <a href="javascript:void(0);" class="title" @click.prevent="messageDetails(m.id)">@{{ m.subject }}</a>
                                    </div>
                                    <div class="col-mail col-mail-2" @click.prevent="messageDetails(m.id)">
                                        <a href="javascript:void(0);" class="subject">@{{m.message}}</span>
                                        </a>
                                        <div class="date">@{{ m.created_at }}</div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <!-- end .mt-4 -->

                    <div class="row">
                        <div class="col-7 mt-1">
                            Showing @{{pagination.from}} - @{{pagination.to}} of @{{pagination.total}}
                        </div> <!-- end col-->
                        <div class="col-5">
                            <div class="btn-group float-right">
                                <template  v-if="pagination.current_page == 1">
                                    <button type="button" class="btn btn-light btn-sm" disabled>
                                        <i class="mdi mdi-chevron-left"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-light btn-sm"
                                        @click.prevent="paginate(pagination.first_page_url)">
                                        <i class="mdi mdi-chevron-left"></i>
                                    </button>
                                </template>
                                <template v-if="pagination.current_page == pagination.last_page">
                                    <button type="button" class="btn btn-info btn-sm">
                                        <i class="mdi mdi-chevron-right"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click.prevent="paginate(pagination.next_page_url)">
                                        <i class="mdi mdi-chevron-right"></i>
                                    </button>
                                </template>
                            </div>
                        </div> <!-- end col-->
                    </div>
                </template>
                <template v-else>
                    <div class="mt-3">
                        <ul class="message-list">
                            <li>
                                <div class="col-mail col-mail-2">
                                    No emails found.
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
                <!-- end row-->
            </div> 
            <!-- end inbox-rightbar-->

            <div class="clearfix"></div>
        </div> <!-- end card-box -->

    </div> <!-- end Col -->
</div><!-- End row -->
@endsection
@section('additional-js')
    <script src="{{asset('admin')}}/libs/sweetalert/sweetalert.min.js"></script>
    <script src="{{ asset('admin/libs') }}/axios/vue.js"></script>
    <script src="{{ asset('admin/libs') }}/axios/axios.min.js"></script>
    <script>
        var vm = new Vue({
            el: "#app",
            data: function(){
                return{
                    search: '',
                    count: [],
                    messages: [],
                    pagination: [],
                    message_ids: [],
                }
            },
            mounted: function() {
                this.listMessages();
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
                },
                filterMessages: function(){
                    let thisReference = this;
                    axios.get(baseUrl + 'get-draft-emails?page=1&search='+thisReference.search)
                        .then(function(response) {
                            thisReference.messages = response.data.payload;
                            thisReference.pagination = response.data.meta_data.pagination;

                        }).catch(function(error) {
                        });
                },
                paginate: function(url){
                    let thisReference = this;
                    if(thisReference.search != ''){
                        url +='&search='+thisReference.search;
                    }
                    axios.get(url)
                        .then(function(response) {
                            thisReference.messages = response.data.payload;
                            thisReference.pagination = response.data.meta_data.pagination;

                        }).catch(function(error) {
                        });
                },
                listMessages: function(){
                    let thisReference = this;
                    axios.get(baseUrl + 'get-draft-emails')
                        .then(function(response) {
                            thisReference.messages = response.data.payload;
                            thisReference.pagination = response.data.meta_data.pagination;

                        }).catch(function(error) {
                        });
                },
                trashMessages: function(){
                    let thisReference = this;
                    if(thisReference.message_ids.length < 1){
                        swal({
                            title: "Please select email to trash ?",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#136ba7",
                            confirmButtonText: "Ok",
                            closeOnConfirm: true,
                            closeOnCancel: false
                        });
                    }else{
                        axios.post(baseUrl + 'update-emails', {_token: csrfToken, ids: thisReference.message_ids, action: 'trash'})
                        .then(function(response) {
                            thisReference.message_ids = [];
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
                                    i.NotificationApp.send('Emails',response.data.message,"top-right","#5ba035","success");
                                    
                            }(window.jQuery);
                            thisReference.listMessages();
                            thisReference.countMessages();
                        }).catch(function(error) {
                        });
                    }
                },
                readMessages: function(){
                    let thisReference = this;
                    if(thisReference.message_ids.length < 1){
                        swal({
                            title: "Please select email to trash ?",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#136ba7",
                            confirmButtonText: "Ok",
                            closeOnConfirm: true,
                            closeOnCancel: false
                        });
                    }else{
                        axios.post(baseUrl + 'update-emails', {_token: csrfToken, ids: thisReference.message_ids, action: 'read'})
                        .then(function(response) {
                            thisReference.message_ids = [];
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
                                    i.NotificationApp.send('Emails',response.data.message,"top-right","#5ba035","success");
                                    
                            }(window.jQuery);
                            thisReference.listMessages();
                            thisReference.countMessages();
                        }).catch(function(error) {
                        });
                    }
                },
                messageDetails: function(id){
                    var url = baseUrl+'emails/'+id;
                    window.location = url;
                }
            }
        });
    </script>
@endsection