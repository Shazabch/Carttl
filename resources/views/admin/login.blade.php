@extends('layouts.main')
@section('title', 'Log In')
@section('content')
    <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
        <!--begin::Content header-->
        {{-- <div class="position-absolute top-0 right-0 text-right mt-5 mb-15 mb-lg-0 flex-column-auto justify-content-center py-5 px-10">
        <span class="font-weight-bold text-dark-50">Dont have an account yet?</span>
        <a href="{{ route('register') }}" class="font-weight-bold ml-2" id="">Sign Up!</a>
    </div> --}}
        <!--end::Content header-->
        <!--begin::Content body-->
        <div class="">

            <!--begin::Signin-->
            <div class="">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif



                <form method="POST" action="{{ route('admin.authenticate') }}" class="form" novalidate="novalidate">
                    @csrf

                    {{-- Username/Email Field with password toggle --}}
                    <div class="mb-4 position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <div class="form-floating">
                            {{-- Changed type to "password" to allow toggling --}}
                            <input type="password" name="email" class="form-control  @error('email') is-invalid @enderror"
                                id="username" placeholder="Username">
                            <label for="username">Username</label>
                        </div>

                    </div>

                    {{-- Password Field with password toggle --}}
                    <div class="mb-4 position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        {{-- Eye icon to toggle visibility --}}
                        <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 100;">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe" name="remember-me">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Sign In
                    </button>

                    <div class="text-center text-muted">
                        <p class="mb-1">©{{ now()->year }} GoldenX Admin Panel</p>
                    </div>
                </form>


            </div>
            <!--end::Signin-->
        </div>
        <!--end::Content body-->
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const setupPasswordToggle = (toggleId, inputId) => {
            const toggleElement = document.getElementById(toggleId);
            const inputElement = document.getElementById(inputId);

            if (!toggleElement || !inputElement) {
                return;
            }

            const iconElement = toggleElement.querySelector('i');

            toggleElement.addEventListener('click', () => {
                const isPassword = inputElement.getAttribute('type') === 'password';
                inputElement.setAttribute('type', isPassword ? 'text' : 'password');

                // Toggle icon class
                iconElement.classList.toggle('fa-eye-slash');
                iconElement.classList.toggle('fa-eye');
            });
        };

        // Setup toggle for both username and password fields
        setupPasswordToggle('toggleUsername', 'username');
        setupPasswordToggle('togglePassword', 'password');
    });
</script>

@endsection



