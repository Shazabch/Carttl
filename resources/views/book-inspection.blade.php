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
<section class="inspection-success-story">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <h2 class="h-35 fw-700">Car Inspection Success Stories</h2>
                <p class="">Hear from our satisfied customers who trusted us with their car inspections.</p>
            </div>
        </div>
    </div>
    <div class="testimonail_slider slider-testimonal owl-carousel owl-theme">
        <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
            <div class="item-wrap">
                <div class="item-wrap-header">
                    <ul class="item-wrap-stars">
                        <li>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </li>
                    </ul>
                </div>
                <div class="item-wrap-content">
                    <p>
                        Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                        vehicle, but the prices were also very competitive.
                    </p>
                </div>
                <div class="item-wrap-bio">
                    <div class="item-wrap-details">
                        <div class="item-avatar">
                            <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                        </div>
                        <div class="item-wrap-info">
                            <strong class="item-wrap-name">Floyd Miles</strong>
                            <span class="item-wrap-title">Project Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
            <div class="item-wrap">
                <div class="item-wrap-header">
                    <ul class="item-wrap-stars">
                        <li>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </li>
                    </ul>
                </div>
                <div class="item-wrap-content">
                    <p>
                        Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                        vehicle, but the prices were also very competitive.
                    </p>
                </div>
                <div class="item-wrap-bio">
                    <div class="item-wrap-details">
                        <div class="item-avatar">
                            <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                        </div>
                        <div class="item-wrap-info">
                            <strong class="item-wrap-name">Floyd Miles</strong>
                            <span class="item-wrap-title">Project Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
            <div class="item-wrap">
                <div class="item-wrap-header">
                    <ul class="item-wrap-stars">
                        <li>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </li>
                    </ul>
                </div>
                <div class="item-wrap-content">
                    <p>
                        Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                        vehicle, but the prices were also very competitive.
                    </p>
                </div>
                <div class="item-wrap-bio">
                    <div class="item-wrap-details">
                        <div class="item-avatar">
                            <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                        </div>
                        <div class="item-wrap-info">
                            <strong class="item-wrap-name">Floyd Miles</strong>
                            <span class="item-wrap-title">Project Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
            <div class="item-wrap">
                <div class="item-wrap-header">
                    <ul class="item-wrap-stars">
                        <li>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </li>
                    </ul>
                </div>
                <div class="item-wrap-content">
                    <p>
                        Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                        vehicle, but the prices were also very competitive.
                    </p>
                </div>
                <div class="item-wrap-bio">
                    <div class="item-wrap-details">
                        <div class="item-avatar">
                            <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                        </div>
                        <div class="item-wrap-info">
                            <strong class="item-wrap-name">Floyd Miles</strong>
                            <span class="item-wrap-title">Project Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
            <div class="item-wrap">
                <div class="item-wrap-header">
                    <ul class="item-wrap-stars">
                        <li>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </li>
                    </ul>
                </div>
                <div class="item-wrap-content">
                    <p>
                        Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                        vehicle, but the prices were also very competitive.
                    </p>
                </div>
                <div class="item-wrap-bio">
                    <div class="item-wrap-details">
                        <div class="item-avatar">
                            <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                        </div>
                        <div class="item-wrap-info">
                            <strong class="item-wrap-name">Floyd Miles</strong>
                            <span class="item-wrap-title">Project Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-faq ox-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="h-35 fw-700 mb-4 text-center" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">Car Inspection FAQs</h2>
                <div class="custom-accordion white" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                What is included in your car inspection?
                            </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Our inspection covers engine, brakes, suspension, lights, tyres, bodywork, interior components, and road test evaluation.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                How long does a vehicle inspection take?
                            </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>The inspection usually takes 1.5 to 2 hours depending on the vehicle type and the level of service selected.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Can I book an inspection at my home or office?
                            </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Yes, we offer mobile inspection services where our certified inspector comes to your location for maximum convenience.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                Do I get a report after the inspection?
                            </button>
                            </h2>
                            <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Yes, a detailed digital inspection report is provided via email with findings, images, and recommendations.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                Is your inspection report valid for resale or insurance?
                            </button>
                            </h2>
                            <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Our reports are professionally formatted and accepted by most buyers, sellers, and insurance providers for documentation purposes.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                What happens if issues are found during inspection?
                            </button>
                            </h2>
                            <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>You’ll receive a list of issues found, along with photos and recommendations for repairs or maintenance actions.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                How much does a car inspection cost?
                            </button>
                            </h2>
                            <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Our inspection packages start from £59. The price depends on the vehicle type and the level of inspection you choose.</p>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEight">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                                Can I inspect a car before purchasing it?
                            </button>
                            </h2>
                            <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Absolutely. Pre-purchase inspections are one of our most requested services to ensure you're making a safe and informed decision.</p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection