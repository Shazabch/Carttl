@extends('layouts.guest')

@section('meta_title', 'Book Inspection - GoldenX')
@section('meta_description', 'Book Inspection - GoldenX.')
@section('canonical',"")

@section('script_css')
<meta itemprop="image" content="">
<meta property="og:image" content="" />
<meta name="twitter:image" content="" />
@append

@section('content')
<section class="book-inspection-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="book-inspection-title banner-heading text-dark">Inspection Made Easy — Book Now!</h1>
                <p class="book-inspection-description">
                    Booking an inspection has never been simpler. Choose your preferred date and time, and let us handle the rest. Get a clear, up-close view before making any decisions — fast, convenient, and tailored to your needs.
                </p>
            </div>
            <div class="col-lg-6">

            </div>
        </div>
    </div>
</section>
@livewire('book-inspection-component')
@endsection