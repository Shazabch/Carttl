<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Package Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 0; }
        .container { padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 150px; margin-bottom: 10px; }
        h1 { margin: 0; font-size: 24px; }
        .details, .package { width: 100%; margin-bottom: 20px; }
        .details td, .package td { padding: 8px; border: 1px solid #ddd; }
        .package th { background-color: #f4f4f4; padding: 8px; border: 1px solid #ddd; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/caartl.png') }}" class="logo" alt="Logo">
            <h1>Package Invoice</h1>
            <p>Date: {{ $date }}</p>
        </div>

        <table class="details">
            <tr>
                <td><strong>User Name:</strong> {{ $user->name }}</td>
                <td><strong>Email:</strong> {{ $user->email }}</td>
                <td><strong>Phone:</strong> {{ $user->phone }}</td>
            </tr>
        </table>

        <table class="package">
            <tr>
                <th>Package Name</th>
               
                <th>Price</th>
                 <th>Duration</th>
            </tr>
            <tr>
                <td>{{ $package->name }}</td>
                <td>{{ $package->price }}</td>
                <td>{{ $package->duration_days }}</td>
            </tr>
        </table>

        <div class="footer">
            Thank you for your purchase!
        </div>
    </div>
</body>
</html>
