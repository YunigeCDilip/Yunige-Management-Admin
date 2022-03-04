@extends('layouts.layout')
@section('additional-css')

@endsection
@section('content') 
<div class="row">
    <div class="col-md-6">
        <div class="card-box" id="localization">
            <h4 class="header-title">{{__('messages.languages')}}</h4>
            <p class="sub-header">
                {{__('messages.change_language')}}
            </p>
            @forelse($locales as $locale)
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$locale->id}}" name="locale" value="{{$locale->id}}" @if($locale->active_status) checked @endif>
                    <label class="custom-control-label" for="customSwitch{{$locale->id}}">{{$locale->country}}</label>
                </div>
                @empty
            @endforelse
        </div> <!-- end col -->
    </div>
</div>    
<!-- end page title --> 
@endsection
@section('additional-js')
<script>
    function messages(message, type){
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
        $('#localization').find('input[name="locale"]').on('change', function(e){
            e.preventDefault();
            $('#localization').find('input[name="locale"]').prop('checked', false);
            var $val = $(this).val();
            $(this).prop('checked', true);
            $.post(baseUrl+'settings', {_token: csrfToken, id: $val}, function(data){
                messages(data.message, data.status);
                setTimeout(function(){
                    location.reload();
                }, 1000)
            });
        });
    });
</script>
@endsection