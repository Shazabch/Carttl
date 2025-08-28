@extends('layouts.auth')
@section('title')
    Reset Password - GoldenX
@endsection

@section('content')
    <div class="col-lg-6 align-items-center justify-content-center bg-white d-flex">

        <div class="w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <h1 class="fw-bold mb-2">Reset Password</h1>
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
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}"
                                required readonly>
                        </div>

                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
