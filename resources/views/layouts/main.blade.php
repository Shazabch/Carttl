<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 1200px;
            margin: 2rem auto;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .car-bg {
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.9), rgba(231, 76, 60, 0.8)),
                url('https://images.unsplash.com/photo-1634823005888-11796723fd70?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8ZHViYWklMjBjYXJ8ZW58MHx8MHx8fDA%3D') center/cover no-repeat;
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 600px;
        }

        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #e74c3c;
            border-color: #e74c3c;
            transform: translateY(-2px);
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.25);
            border-color: #e74c3c;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 17px;
            color: #2c3e50;
            z-index: 5;
        }

        .form-floating label {
            padding-left: 50px;
        }

        .form-floating .form-control {
            padding-left: 50px;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .forgot-password {
            color: #e74c3c;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-password:hover {
            color: #2c3e50;
        }

        .login-form-container {
            padding: 3rem;
        }

        @media (max-width: 991.98px) {
            .car-bg {
                min-height: 300px;
                padding: 2rem;
            }

            .login-form-container {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="row g-0">
            <div class="col-lg-12">
                <div class="card login-card">
                    <div class="row g-0">
                        <!-- Left side with car image and branding -->
                        <div class="col-lg-6 car-bg">
                            <h1 class="display-4 fw-bold mb-4">GoldenX</h1>
                            <p class="lead mb-5">Premium car selling and auction platform administration</p>
                            <div class="row mt-4">
                                <div class="col-md-4 text-center mb-4">
                                    <i class="fas fa-car-side fa-3x mb-3"></i>
                                    <h5>Premium Listings</h5>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <i class="fas fa-gavel fa-3x mb-3"></i>
                                    <h5>Live Auctions</h5>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                                    <h5>Market Analytics</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Right side with login form -->
                        <div class="col-lg-6">
                            <div class="login-form-container">
                                <div class="text-center mb-4">
                                    <div class="logo-container mx-auto">
                                        <i class="fas fa-car fa-3x text-primary"></i>
                                    </div>
                                    <h2 class="fw-bold">Admin Login</h2>
                                    <p class="text-muted">Please sign in to continue</p>
                                </div>

                                @yield('content')



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
