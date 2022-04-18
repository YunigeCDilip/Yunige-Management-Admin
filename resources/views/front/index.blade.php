@extends('layouts.front.layout')
@section('additional-css')
    <style>
        .card-img {
            width: 60px;
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
        <div class="card " style="width: 20rem">
            <div class="d-flex justify-content-center">
                <img class="card-img card-img-top" src="admin/images/sakura.png" alt="Card image cap"> 
            </div>

            <div class="card-body">

                <h3 class="card-title d-flex justify-content-center">Sakura</h3>
                <p class="card-text d-flex justify-content-center">This sentence is the content of the card.</p>
                <div class=" d-flex justify-content-center"><a href="#" class="btn btn-primary">Join</a></div>
            </div>
        </div>
        <div class="card" style="width: 20rem">
            <div class="d-flex justify-content-center">
                <img class="card-img card-img-top" src="admin/images/panda.png" alt="Card image cap"> 
            </div>

            <div class="card-body">

                <h3 class="card-title d-flex justify-content-center">Panda</h3>
                <p class="card-text d-flex justify-content-center">This sentence is the content of the card.</p>
                <div class=" d-flex justify-content-center"><a href="#" class="btn btn-primary">Join</a></div>

            </div>
        </div>
        <div class="card" style="width: 20rem">
            <div class="d-flex justify-content-center">
                <img class="card-img card-img-top" src="admin/images/brand-icon.png" alt="Card image cap"> 
            </div>
            <div class="card-body">

                <h3 class="card-title d-flex justify-content-center">Monaka</h3>
                <p class="card-text d-flex justify-content-center">This sentence is the content of the card.</p>
                <div class=" d-flex justify-content-center"><a href="#" class="btn btn-primary">Join</a></div>

            </div>
        </div>
    </div>
</div>


@endsection
@section('additional-js')
@endsection