@extends('layouts.guest')
@section('title')
    Favorites
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center my-5">
            @include('components.guest.listing-card')
        </div>
    </div>
@endsection
