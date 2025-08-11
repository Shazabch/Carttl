@extends('layouts.guest')

@section('content')
<div class="container my-4 my-md-5">
    <div class="row g-4">
        {{-- Left Sidebar Navigation --}}
        {{-- ADDED: "d-none d-md-block" to hide sidebar on mobile --}}
        <div class="col-md-4 col-lg-3 dashboard-sidebar d-none d-md-block">
            <div class="card">
                <div class="card-header">
                    <h5>My Account</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-user-circle fa-fw"></i> Profile
                    </a>

                    <!-- <a href="{{ route('account-settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account-settings') ? 'active' : '' }}">
                        <i class="fas fa-cog fa-fw"></i> Account Settings
                    </a> -->
                    <a href="{{ route('notification-settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('notification-settings') ? 'active' : '' }}">
                        <i class="fas fa-bell fa-fw"></i> Notifications
                    </a>
                    <a href="{{ route('biddings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('biddings') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt fa-fw"></i> Biddings
                    </a>
                    <!-- <a href="{{ route('my-ads') }}" class="list-group-item list-group-item-action {{ request()->routeIs('my-ads') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn fa-fw"></i> My Ads
                    </a> -->
                    <a href="{{ route('car-enquiries') }}" class="list-group-item list-group-item-action {{ request()->routeIs('car-enquiries') ? 'active' : '' }}">
                        <i class="fas fa-briefcase fa-fw"></i> Car Enquiries
                    </a>
                    <a href="{{ route('car-appointments') }}" class="list-group-item list-group-item-action {{ request()->routeIs('car-appointments') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check fa-fw"></i>Inspection Reports
                    </a>
                    <a class="list-group-item list-group-item-action logout-link" href="{{ route('account.logout') }}">
                        <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Right Content Area --}}
        {{-- CHANGED: to "col-12" on mobile to take full width --}}
        <div class="col-12 col-md-8 col-lg-9 dashboard-content">
            @yield('dashboard-content')
        </div>
    </div>
</div>


{{-- ============================================= --}}
{{-- NEW: MOBILE BOTTOM NAVIGATION BAR & OFFCANVAS --}}
{{-- ============================================= --}}

{{-- This entire block is only visible on mobile (d-md-none) --}}
<div class="d-md-none">

    {{-- The Bottom Navigation Bar --}}
    <nav class="mobile-bottom-nav">

        <a href="{{ route('account.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
        </a>
        <a href="{{ route('my-ads') }}" class="mobile-nav-item {{ request()->routeIs('my-ads') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i>
            <span>My Ads</span>
        </a>
        <a href="{{ route('car-appointments') }}" class="mobile-nav-item {{ request()->routeIs('car-appointments') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Bookings</span>
        </a>

        {{-- The "More" button to trigger the offcanvas menu --}}
        {{-- It's active if ANY of the routes inside the offcanvas are active --}}
        
    </nav>

    {{-- The Offcanvas Menu that slides up from the bottom --}}
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileMenuLabel">More Options</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            {{-- We reuse the same list-group styling for consistency --}}
            <div class="list-group list-group-flush dashboard-sidebar">
               
                <a href="{{ route('account-settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account-settings') ? 'active' : '' }}">
                    <i class="fas fa-cog fa-fw"></i> Account Settings
                </a>
                <a href="{{ route('notification-settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('notification-settings') ? 'active' : '' }}">
                    <i class="fas fa-bell fa-fw"></i> Notifications
                </a>
                <a href="{{ route('car-enquiries') }}" class="list-group-item list-group-item-action {{ request()->routeIs('car-enquiries') ? 'active' : '' }}">
                    <i class="fas fa-briefcase fa-fw"></i> Car Enquiries
                </a>
                <a class="list-group-item list-group-item-action logout-link" href="{{ route('account.logout') }}">
                    <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>
@endsection