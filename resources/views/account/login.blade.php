@extends('layouts.auth')
@section('title')
    Login - GoldenX
@endsection
@section('content')
    <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
        <div class="w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <h1 class="fw-bold mb-2">Sign In</h1>
                <p class="text-secondary">Access your account to manage bids and listings</p>
            </div>
            <!-- <div class="d-flex gap-2 mb-4">
                                <a href="#"
                                    class="btn btn-outline-secondary w-50 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fab fa-google"></i> Google
                                </a>
                                <a href="#"
                                    class="btn btn-outline-secondary w-50 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fab fa-apple"></i> Apple
                                </a>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                <hr class="flex-grow-1">
                                <span class="mx-2 text-secondary text-uppercase small">or continue with</span>
                                <hr class="flex-grow-1">
                            </div> -->
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>
            </div>
            <form action="{{ route('account.authenticate') }}" method="post">
                @csrf
                <div class="row gy-3 overflow-hidden">
                    <div class="col-12">
                        <div>
                            <label for="email" class="form-label fw-medium">Email Address</label>
                            <input value="{{ old('email') }}" type="text"
                                class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                placeholder="name@example.com">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Added position-relative to this div to act as a container for the icon --}}
                        <div class="position-relative">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" value="" placeholder="Password">

                            {{-- Eye icon to toggle password visibility --}}
                            <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor: pointer; margin-top: 12px;">
                                <i class="fas fa-eye-slash"></i>
                            </span>

                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check ">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>

                            </div>
                            <a href="{{ route('password.request') }}"
                                class="text-warning fw-medium text-decoration-none">Forgot password?</a>
                        </div>
                        <div class="text-center mt-4 text-secondary">
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-3">Sign In</button>
                            <p>Don't have an account? <a href="{{ route('account.register') }}"
                                    class="text-warning fw-medium text-decoration-none">Create an
                                    account</a></p>
                            <div class="mb-3"> {{-- Added margin-bottom here --}}
                                <button type="button" onclick="window.history.back()" class="btn btn-dark btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Check the current type of the input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
@endsection
