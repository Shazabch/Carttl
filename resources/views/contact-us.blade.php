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
    <section>
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h3 class="sec-h-top">Contact Us</h3>
                    <h2 class="h-35 fw-700">Get in touch with our team for any inquiries</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact-form-card">
                        <div class="card-body">
                            <livewire:contact-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
