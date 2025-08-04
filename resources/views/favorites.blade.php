@extends('layouts.guest')
@section('title')
    Favorites
@endsection

@section('content')
    <section class="bg-light pb-0">
        <div class="container">
            <div class="bg-white rounded-4 py-5">
                <div class="row justify-content-center text-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="">
                            <div class="mb-4">
                                <img src="{{asset('images/icons/login.svg')}}" alt="Login Icon" width="130">
                            </div>
                            <h2 class="h-35 fw-700">Please Log In to Save Your Preferences</h2>
                            <p class="text-muted mb-4">
                                Create an account or log in to keep track of your favourite vehicles across all your devices. 
                                Stay updated on price drops, new listings, and auction reminders.
                            </p>
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('account.login') }}" class="btn-main">Log In</a>
                                <a href="{{ route('account.register') }}" class="btn-main">Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-fav">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="fav-wrap">
                        <div class="pb-3 pt-2">
                            <h2 class="h-35 fw-700">My Favorites</h2>
                        </div>
                        <div class="fav-inner">
                            <div class="row">
                                    @include('components.guest.listing-card')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="not-added-fav">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-10 col-lg-12">
                    <div class="p-5 not-added-fav-inner">
                        <div class="mb-4">
                           <i class="fa-solid fa-heart h-40 text-accent"></i>
                        </div>
                        <h2 class="fw-bold mb-3 text-dark">You Haven’t Added Any Cars Yet</h2>
                        <p class="text-muted mb-4">
                            Browse through our listings and click the 
                            <span class="text-warning fw-bold"><i class="fa-solid fa-heart text-accent"></i></span> icon on any car to add it to your favourites. 
                            It’s a great way to compare options and keep an eye on what you love.
                        </p>
                        <a href="{{route('sell-car')}}" class="btn-main">
                            Browse Cars
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
