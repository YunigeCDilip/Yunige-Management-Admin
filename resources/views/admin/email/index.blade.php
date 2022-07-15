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
        <div class="card-box">
            <!-- Left sidebar -->
            @include('admin.email.partials.menu')
            <!-- End Left sidebar -->
            <div class="inbox-rightbar" id="app" v-cloak>
                @include('admin.email.partials.actions')
                <div class="mt-3">
                    <ul class="message-list">
                        <template v-for="m in messages">
                            <li :class="m.read ? '' : 'unread'">
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk1">
                                        <label for="chk1" class="toggle"></label>
                                    </div>
                                    <span class="star-toggle far fa-star" :class="m.read ? 'text-success' : ''"></span>
                                    <a href="" class="title">@{{ m.subject }}</a>
                                </div>
                                <div class="col-mail col-mail-2">
                                    <a href="" class="subject">@{{m.message}}</span>
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
                    messages: [],
                    pagination: [],
                }
            },
            mounted: function() {
                this.listMessages();
            },
            methods: {
                paginate: function(url){
                    let thisReference = this;
                    axios.get(url)
                        .then(function(response) {
                            thisReference.messages = response.data.payload;
                            thisReference.pagination = response.data.meta_data.pagination;

                        }).catch(function(error) {
                        });
                },
                listMessages: function(){
                    let thisReference = this;
                    axios.get(baseUrl + 'get-emails')
                        .then(function(response) {
                            thisReference.messages = response.data.payload;
                            thisReference.pagination = response.data.meta_data.pagination;

                        }).catch(function(error) {
                        });
                }
            }
        });
    </script>
@endsection