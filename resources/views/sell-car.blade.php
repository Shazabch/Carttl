@extends('layouts.guest')

@section('title')
Sell your car
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
                        {{-- <i class="fas fa-envelope text-warning me-2"></i>
                        Contact Us --}}
                    </h2>
                    <p class="text-muted mb-0">Sell Your Car here </p>
                </div>

                <div class="card-body">
                    <livewire:sell-car-component/>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection