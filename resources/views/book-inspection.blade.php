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
<section class="inner-banner p-0">
    <div id="themeSlider" class="carousel slide pointer-event">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('images/banners/page-header-bg.jpg')}}" class="banner_bg" alt="">
                <div class="caption-head">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row row-eq-height">
                                <div class="col-lg-7 align-self-center">
                                    <div class="content_box_wrapper" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                                        <h1 class="book-inspection-title banner-heading">Inspection Made Easy — <span class="text-accent">Book Now!</span></h1>
                                        <p class="py-3">
                                            Booking an inspection has never been simpler. Choose your preferred date and time, and let us handle the rest. Get a clear, up-close view before making any decisions — fast, convenient, and tailored to your needs.
                                        </p>
                                        <a href="" class="btn-main dark scrollTo" data-target=".inpsection-wrapper">Book Inspection Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@livewire('book-inspection-component')
<section class="why-choose-us-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h3 class="sec-h-top">Why Choose Us?</h3>
                <h2 class="h-35 fw-700">Skilled Technicians. Clear Reporting. Confidence in Every Drive.</h2>
            </div>
        </div>
        <div class="row g-4 text-start">
            <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="service-card h-100">
                    <div class="service-card-inner">
                        <div class="icon-wrapper">
                            <img src="{{ asset('images/icons/s1.svg') }}" alt="Car with Driver" width="24">
                        </div>
                        <h5 class="p-20 fw-600">Certified Mechanics</h5>
                        <p class="text-muted mb-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque incidunt adipisci delectus quas excepturi minus, reiciendis nostrum amet voluptatum blanditiis, natus laudantium at nihil et tempora. Exercitationem totam distinctio quam!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="service-card h-100">
                    <div class="service-card-inner">
                        <div class="icon-wrapper">
                            <img src="{{ asset('images/icons/s2.svg') }}" alt="Business Car" width="24">
                        </div>
                        <h5 class="p-20 fw-600">Comprehensive Checks</h5>
                        <p class="text-muted mb-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque incidunt adipisci delectus quas excepturi minus, reiciendis nostrum amet voluptatum blanditiis, natus laudantium at nihil et tempora. Exercitationem totam distinctio quam!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="service-card h-100">
                    <div class="service-card-inner">
                        <div class="icon-wrapper">
                            <img src="{{ asset('images/icons/s3.svg') }}" alt="Airport Transfer" width="24">
                        </div>
                        <h5 class="p-20 fw-600">On-site or At-Your-Door</h5>
                        <p class="text-muted mb-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque incidunt adipisci delectus quas excepturi minus, reiciendis nostrum amet voluptatum blanditiis, natus laudantium at nihil et tempora. Exercitationem totam distinctio quam!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="cta-section ox-hidden">
    <div class="container">
        <div class="row">
            <div class="col-lg-7" data-aos="fade-down" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <h2 class="h-35 fw-700">How Our Company Performs a Car Inspection</h2>
                <h4 class="p-20 fw-600 my-4">Step-by-Step Process:</h4>
                <ul class="theme_list">
                    <li class="mb-2">Booking Confirmation – Once you book, our team confirms your inspection slot.</li>
                    <li class="mb-2">Preliminary Assessment – Basic exterior and tire checks.</li>
                    <li class="mb-2">In-depth Technical Inspection – Brake pads, fluid levels, suspension, battery, lights, leaks.</li>
                    <li class="mb-2">Interior & Safety Check – Dashboard lights, seat belts, horn, airbags, windows.</li>
                    <li class="mb-2">Test Drive (If Required) – We test the car for noise, vibration, handling.</li>
                    <li class="mb-2">Final Report – You receive a detailed digital report with observations and recommendations.</li>
                </ul>
            </div>
            <div class="col-lg-5 text-center">
                <div data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <img src="{{ asset('images/jeep.png') }}" alt="Car Image" class="cta-img" />
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonail -->
@livewire('testimonial-listing-component')
<x-faq />
@endsection