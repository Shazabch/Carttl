<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 150px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/caartl.png') }}" class="logo" alt="Logo">
        <h2>Booking Invoice</h2>
        <p>Date: {{ $date }}</p>
    </div>

    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
    <p><strong>Vehicle:</strong> {{ $booking->vehicle?->brand?->name ?? '-' }} {{ $booking->vehicle?->vehicleModel?->name ?? '-' }}</p>
    <p><strong>Customer:</strong> {{ $booking->user->name ?? '-' }}</p>
    <p><strong>Receiver:</strong> {{ $booking->receiver_name }} ({{ $booking->receiver_email }})</p>
    <p><strong>Delivery Type:</strong> {{ ucfirst(str_replace('_', ' ', $booking->delivery_type)) }}</p>

    @if($booking->services)
        <h4>Services</h4>
        <table>
            <thead>
                <tr><th>Name</th><th>Price</th></tr>
            </thead>
            <tbody>
                @foreach(json_decode($booking->services, true) as $service)
                    <tr>
                        <td>{{ $service['name'] }}</td>
                        <td>{{ number_format($service['price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($booking->fixed_fees)
        <h4>Fixed Fees</h4>
        <table>
            <thead>
                <tr><th>Name</th><th>Price</th></tr>
            </thead>
            <tbody>
                @foreach(json_decode($booking->fixed_fees, true) as $fee)
                    <tr>
                        <td>{{ $fee['name'] }}</td>
                        <td>{{ number_format($fee['price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h3>Total Amount: {{ number_format($booking->total_amount, 2) }}</h3>
</body>
</html>
