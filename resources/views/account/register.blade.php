@extends('layouts.auth')
@section('title')
Register - GoldenX
@endsection
@section('content')
<div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">

    <div class="w-100">
        <div class="d-flex align-items-center justify-content-center bg-white min-vh-100">
            <div class="w-100" style="max-width: 600px;">
                <div class="text-center mb-4">
                    <h1 class="fw-bold mb-2">Create Account</h1>
                    <p class="text-secondary">Join our exclusive community of automotive enthusiasts</p>
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
                        <span class="mx-2 text-secondary text-uppercase small">or register with</span>
                        <hr class="flex-grow-1">
                    </div> -->
                <form action="{{ route('account.processRegister') }}" method="POST" class="mb-0">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control form-control-lg"
                                    placeholder="John Doe" required>
                                @error('name')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg"
                                    placeholder="your@email.com" required>
                                @error('email')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg pe-5" placeholder="••••••••" required
                                    onkeyup="checkPasswordStrength()">
                                <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; margin-top: 12px;">
                                    <i class="fas fa-eye-slash"></i>
                                </span>

                                @error('password')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" id="strength-meter-fill" role="progressbar"
                                        style="width: 0%;"></div>
                                </div>
                                <div class="small text-muted mt-1" id="strength-text">Password strength</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 position-relative">
                                <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control form-control-lg pe-5" placeholder="••••••••" required>
                                <span id="togglePassword2" class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; margin-top: 12px;">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the
                            <a href="{{route('terms')}}" class="text-warning fw-medium text-decoration-none">Terms of Service</a>
                            and
                            <a href="{{route('privacy-policy')}}" class="text-warning fw-medium text-decoration-none">Privacy Policy</a>
                        </label>
                    </div>
                    <livewire:captcha />
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-3">Create Account</button>
                </form>

                <div class="text-center mt-4 text-secondary">

                    <p>Already have an account? <a href="{{ route('account.login') }}"
                            class="text-warning fw-medium text-decoration-none">Sign in</a></p>
                             <div class="mb-3"> {{-- Added margin-bottom here --}}
                        <button type="button" onclick="window.history.back()" class="btn btn-dark btn-sm">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
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
         const togglePassword2 = document.getElementById('togglePassword2');
        const passwordInput2 = document.getElementById('password_confirmation');

        if (togglePassword2 && passwordInput2) {
            togglePassword2.addEventListener('click', function() {
                // Check the current type of the input
                const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput2.setAttribute('type', type);

                // Toggle the icon
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const btn = input.nextElementSibling;
        if (input.type === "password") {
            input.type = "text";
            btn.innerHTML = '<i class="far fa-eye-slash"></i>';
        } else {
            input.type = "password";
            btn.innerHTML = '<i class="far fa-eye"></i>';
        }
    }

    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const meter = document.getElementById('strength-meter-fill');
        const text = document.getElementById('strength-text');
        let score = 0;
        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        let width = [0, 25, 50, 75, 100][score];
        let color = ['#e2e8f0', '#ef4444', '#f59e0b', '#10b981', '#0f172a'][score];
        let label = ['Too short', 'Weak', 'Fair', 'Good', 'Strong'][score];
        meter.style.width = width + '%';
        meter.style.backgroundColor = color;
        text.textContent = label;
    }
</script>