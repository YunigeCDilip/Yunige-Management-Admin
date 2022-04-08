@extends('layouts.front.layout')
@section('additional-css')
    <style>
        .card-img {
            width: 60px;
            text-align: center;
        }
    </style>

@endsection
@section('content') 
   
<!-- end page title --> 
<div>
    <div class="card border-info mb-3 text-center">
        <div class="card-body">
            <blockquote class="card-blockquote">
                <h1>Yunige Meeting Rooms!</h1>
                <a href="{{$meeting['join_url']}}" target="_blank" class="btn btn-primary">本部 ROOM</a>
            </blockquote>
        </div>
    </div>



    <div class="card-group">
        <div class="card" style="width: 20rem">
            <div class="card-img">
                <img class="card-img-top" src="admin/images/yunige_avatar.png" alt="Card image cap"> 
            </div>

            <div class="card-body">

                <h3 class="card-title">Sakura</h3>
                <p class="card-text">This sentence is the content of the card.</p>
                <a href="#" class="btn btn-primary">Join</a>
            </div>
        </div>
        <div class="card" style="width: 20rem">
            <div class="card-img">
                <img class="card-img-top" src="admin/images/yunige_avatar.png" alt="Card image cap"> 
            </div>

            <div class="card-body">

                <h3 class="card-title">Panda</h3>
                <p class="card-text">This sentence is the content of the card.</p>
                <a href="#" class="btn btn-primary">Join</a>
            </div>
        </div>
        <div class="card" style="width: 20rem">
            <div class="card-img">
                <img class="card-img-top" src="admin/images/yunige_avatar.png" alt="Card image cap"> 
            </div>
            <div class="card-body">

                <h3 class="card-title">Monaka</h3>
                <p class="card-text">This sentence is the content of the card.</p>
                <a href="#" class="btn btn-primary">Join</a>
            </div>
        </div>
    </div>
</div>


@endsection
@section('additional-js')
@endsection