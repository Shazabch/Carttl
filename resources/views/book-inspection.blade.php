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
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="book-inspection-form">
                    <form class="">
                        <h4 class="mb-4">Book Your Vehicle Inspection</h4>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="e.g. 0300 1234567" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">                            
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="vehicleType" class="form-label">Vehicle Type</label>
                                    <select class="form-select" id="vehicleType" required>
                                    <option value="" selected disabled>Select vehicle type</option>
                                    <option>Car</option>
                                    <option>Van</option>
                                    <option>Truck</option>
                                    <option>Motorbike</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="date" class="form-label">Preferred Date</label>
                                    <input type="date" class="form-control" id="date" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="time" class="form-label">Preferred Time</label>
                                    <input type="time" class="form-control" id="time" required>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="form-group">
                                    <label for="location" class="form-label">Location / Address</label>
                                    <input type="text" class="form-control" id="location" placeholder="Where should we inspect?" required>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="modelYear" class="form-label">Model Year</label>
                                    <input type="number" class="form-control" id="modelYear" placeholder="e.g. 2022" min="1990" max="2099" required>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="vehicleModel" class="form-label">Make</label>
                                    <input type="text" class="form-control" id="vehicleModel" placeholder="e.g. Corolla, Civic, Swift" required>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="number" class="form-control" id="model" placeholder="e.g. 2022" min="1990" max="2099" required>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <button type="submit" class="btn-main dark justify-content-center w-100">Submit Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection