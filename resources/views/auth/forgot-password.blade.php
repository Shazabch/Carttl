@extends('layouts.auth')
@section('title')
    Forget Password - GoldenX
@endsection


@section('content')
    <div class="col-lg-6 align-items-center justify-content-center bg-white d-flex">

        <div class="w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <h1 class="fw-bold mb-2">Forgot Password</h1>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <p class="text-secondary text-right">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password
                    reset link that will allow you to choose a new one.
                </p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-warning text-white">Send Reset Link</button>
                            <a href="{{ route('account.login') }}" class="btn btn-dark text-white">Back To Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
