@extends('layouts.guest')

@section('title')
    Contact Us
@endsection
<style>
    .map-bg-img {
        pointer-events: none;
    }

    .contact-form-card {
        background: transparent !important;
    }
</style>
@section('content')
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 contact-form-card">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80"
                        alt="Map background" class="map-bg-img position-absolute top-0 start-0 w-100 h-100"
                        style="object-fit: cover; opacity: 0.15; z-index: 0;">
                    <div class="card-header bg-white border-0 text-center py-4">
                        <h2 class="mb-2 fw-bold text-dark">
                            <i class="fas fa-envelope text-warning me-2"></i>
                            Contact Us
                        </h2>
                        <p class="text-muted mb-0">Get in touch with our team for any inquiries </p>
                    </div>

                    <div class="card-body">

                        <form id="contactForm">
                            <div class="row ">
                                <div class="col-md-3">
                                    <label class=" mt-1 form-label ">
                                        <i class="fas fa-user text-warning me-1"></i>
                                        First Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " placeholder="Enter your first name"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class=" mt-1 form-label ">
                                        <i class="fas fa-user text-warning me-1"></i>
                                        Last Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " placeholder="Enter your last name" required>
                                </div>

                                <div class="col-md-3">
                                    <label class=" mt-1 form-label ">
                                        <i class="fas fa-envelope text-warning me-1"></i>
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control " placeholder="your.email@example.com"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class=" mt-1 form-label ">
                                        <i class="fas fa-phone text-warning me-1"></i>
                                        Phone Number
                                    </label>
                                    <input type="tel" class="form-control " placeholder="+1 (555) 123-4567">
                                </div>


                            </div>




                            <div class="mt-1">
                                <label class=" mt-1 form-label ">
                                    <i class="fas fa-comment text-warning me-1"></i>
                                    Message <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" rows="5" placeholder="Please provide details about your inquiry..." required></textarea>
                            </div>

                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" id="newsletter" checked>
                                <label class=" mt-1 form-check-label text-muted" for="terms">
                                    I agree to the <a href="#" class="text-warning text-decoration-none ">Terms of
                                        Service</a> and
                                    <a href="#" class="text-warning text-decoration-none ">Privacy
                                        Policy</a>
                                    <span class="text-danger">*</span>
                                </label>
                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                                <button type="submit" class="btn btn-warning text-dark ">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    Send Message
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
