<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon@72x.ico') }}">
    <!-- Chrome for Android theme color -->
    <link rel="shortcut icon" href="{{ asset('images/favicon@72x.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon@72x.ico') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon@72x.ico') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon@72x.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    {{-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css"
        media="all" />
    <link rel="stylesheet" href="{{ asset('owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owl/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guest.css') }}">
    <link rel="stylesheet" href="{{ asset('css/car-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-dashboard.css') }}">
    @stack('styles')
    @livewireStyles
</head>

<body>
    <!-- Navbar -->
    @include('components.guest.header')

    {{-- <button class="floating-inspection-btn" onclick="bookInspection()">
        <i class="fas fa-calendar-alt " style="text-decoration: none"></i>
        <span>Book Inspection</span>
    </button> --}}

    @yield('content')

    @include('components.guest.footer')
    {{-- ======================================================= --}}
    {{-- ============ START: Standard Bootstrap Modal ============ --}}
    {{-- ======================================================= --}}
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <img src="{{ asset('images/icons/login.svg') }}" alt="Login Icon" class="mx-auto" style="height: 90px;">
                    </div>
                    <h3 class="modal-title fw-bold mb-2" id="loginModalLabel">Please Log In</h3>
                    <p class="text-muted mb-4">You need to be logged in to continue. Please log in or create an account.</p>

                    <div class=" text-center">
                        <a href="{{ route('account.login') }}" class="btn-main text-center">Log In</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ======================================================= --}}
    {{-- ============ END: Standard Bootstrap Modal ============== --}}
    {{-- ======================================================= --}}
    <!-- Footer -->


    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"
        integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('owl/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>


    <!-- Optional: Navbar scroll effect -->
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    <script>
        // 1. Create a Bootstrap Modal instance
        const loginModalElement = document.getElementById('loginModal');
        const loginModal = new bootstrap.Modal(loginModalElement);

        // 2. Listen for the global event dispatched by Livewire
        window.addEventListener('show-login-modal', event => {
            // 3. Use the Bootstrap API to show the modal
            loginModal.show();
        });
    </script>

    <script>
        function dubaiPhoneMask() {
            return {
                phone: '',
                formatPhone() {
                    // Remove non-digits
                    let digits = this.phone.replace(/\D/g, '');

                    // Always start with +9715
                    if (!digits.startsWith('9715')) {
                        digits = '9715' + digits.replace(/^971?5?/, '');
                    }

                    // Limit to +971 5 + 8 more digits
                    digits = digits.substring(0, 12);

                    // Add + at start
                    this.phone = '+' + digits;
                }
            }
        }
    </script>
    @livewireScripts
</body>

</html>