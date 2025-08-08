@extends('account.layouts.app')

@section('title', 'Account Settings - Dashboard')

@section('dashboard-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Account Settings</h5>
        </div>
        <div class="card-body">
             <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    Verification expires on 05 Nov 2025. <a href="#" class="alert-link">Renew Verification</a>
                </div>
            </div>
            <p>Here you can update your account settings, like your name, email, and password.</p>
            {{-- Add your forms here --}}
            <button class="btn btn-primary">Update Settings</button>
        </div>
    </div>
@endsection