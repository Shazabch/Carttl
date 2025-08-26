<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('images/favicon@72x.ico') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
        }

        .navbar {
            background-color: rgba(15, 23, 42, 0.95) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand span {
            color: #f59e0b;
        }

        .auth-image {
            background-image: url('images/login.png');
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100%;
        }

        .auth-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background: linear-gradient(to right, rgba(2, 6, 23, 0.8), rgba(15, 23, 42, 0.4)); */
        }

        .auth-image-content {
            position: relative;
            z-index: 1;
            color: #fff;
            padding: 2rem;
        }

        .testimonial {
            background-color: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 8px;
            margin-top: 2rem;
            border-left: 4px solid #f59e0b;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }

        .toggle-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .toggle-btn:hover {
            color: #0f172a;
        }

        .form-error {
            color: #ef4444;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 992px) {
            .auth-image {
                min-height: 300px;
            }
        }
    </style>
</head>

<body>


    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Left: Image & Testimonial -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center p-0 auth-image">

            </div>
            <!-- Right: Login Form -->
            @yield('content')
        </div>
    </div>

    <!-- Password Toggle Script -->
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
    </script>
    <!-- Bootstrap 5 JS (for responsive navbar, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
