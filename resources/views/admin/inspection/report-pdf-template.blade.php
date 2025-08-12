<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Inspection Report #{{ $reportInView->id }}</title>
    
    {{-- Google Fonts & Font Awesome for Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- Customizable CSS Variables --- */
        :root {
            /* 
            * IMPORTANT: Change this color to your brand's primary color.
            */
            --primary-color: #d7b236; /* <--- YOUR COLOR CODE HERE */

            --font-family: 'Roboto', 'Helvetica', sans-serif;
            --border-color: #dee2e6;
            --background-light: #f8f9fa;
            --text-dark: #212529;
            --text-muted: #6c757d;

            /* Status Pill Colors */
            --status-good-bg: #d1e7dd;
            --status-good-text: #0f5132;
            --status-warning-bg: #fff3cd;
            --status-warning-text: #664d03;
            --status-danger-bg: #d7b236;
            --status-danger-text: #842029;
        }

        body {
            font-family: var(--font-family);
            font-size: 11px;
            color: var(--text-dark);
            background-color: #fff;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        /* --- Enhanced Header --- */
        .header {
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 4px solid var(--primary-color);
            /* Using table for robust PDF layout */
            width: 100%;
            border-collapse: collapse;
        }
        .header td {
            vertical-align: middle;
        }
        .header-logo {
            width: 160px;
            text-align: left;
        }
        .header-logo img {
            max-width: 150px;
            max-height: 70px;
        }
        .header-details {
            text-align: right;
        }
        .header-details h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: var(--primary-color);
        }
        .header-details p {
            margin: 5px 0 0;
            font-size: 12px;
            color: var(--text-muted);
        }
        
        /* --- Card-Based Section Design --- */
        .report-card {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 20px;
            page-break-inside: avoid;
            overflow: hidden; /* Ensures border-radius is respected */
        }
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: 500;
        }
        .card-header .fa-solid {
            margin-right: 10px;
            font-size: 15px;
        }
        .card-body {
            padding: 15px;
            background-color: #fff;
        }

        /* --- Robust Table for Data --- */
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table tr {
            border-bottom: 1px solid #f1f1f1;
        }
        .details-table tr:last-child {
            border-bottom: none;
        }
        .details-table td {
            padding: 12px 5px;
            vertical-align: top;
        }
        
        .item-label {
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 5px;
            display: block;
        }
        .item-value {
            font-weight: 400;
            font-size: 12px;
            background-color: var(--background-light);
            padding: 8px 10px;
            border-radius: 2px;
            border: 1px solid var(--border-color);
        }
        .item-value-list {
            list-style-type: none; padding-left: 0; margin: 0;
        }
        .item-value-list li {
            background-color: #e9ecef;
            color: #333;
            padding: 4px 10px;
            margin: 2px;
            display: inline-block;
            border-radius: 15px;
            font-size: 10px;
        }

        /* --- Status Pills for Conditions --- */
        .status-pill {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 500;
            text-transform: capitalize;
        }
        .status-good {
            background-color: var(--status-good-bg);
            color: var(--status-good-text);
        }
        .status-warning {
            background-color: var(--status-warning-bg);
            color: var(--status-warning-text);
        }
        .status-danger {
            background-color: var(--status-danger-bg);
            color:white;
            
        }
        
        /* --- Footer --- */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #aaa;
            width: 100%;
            position: fixed;
            bottom: 0;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header">
            <tr>
                <td class="header-logo">
                    {{-- IMPORTANT: Update the src path to your logo --}}
                    <img src="{{asset('images/golden-x.png')}}" alt="Company Logo">
                </td>
                <td class="header-details">
                    <h1>Vehicle Inspection Report</h1>
                    <p>Report ID: #{{ $reportInView->id }} | Date: {{ $reportInView->created_at->format('F d, Y') }}</p>
                </td>
            </tr>
        </table>

        {{-- Vehicle Information Card --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-car"></i>Vehicle Information</div>
            <div class="card-body">
                <table class="details-table">
                    <tr>
                        <td><div class="item-label">Make</div><div class="item-value">{{ $reportInView->brand?->name ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Trim</div><div class="item-value">{{ $reportInView->vehicleModel?->name ?? 'N/A' }}</div></td>
                    </tr>
                     <tr>
                        <td><div class="item-label">Year</div><div class="item-value">{{ $reportInView->year ?? 'N/A' }}</div></td>
                        <td><div class="item-label">VIN</div><div class="item-value">{{ $reportInView->vin ?? 'N/A' }}</div></td>
                    </tr>
                     <tr>
                        <td><div class="item-label">Odometer</div><div class="item-value">{{ $reportInView->getOdometerLabelAttribute() ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Color</div><div class="item-value">{{ $reportInView->color ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label">No of Cylender</div><div class="item-value">{{ $reportInView->noOfCylinders ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Body Type</div><div class="item-value">{{ $reportInView->body_type ?? 'N/A' }}</div></td>
                    </tr>
                     <tr>
                        <td><div class="item-label">Registered Emirates</div><div class="item-value">{{ $reportInView->registeredEmirates ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Specs</div><div class="item-value">{{ $reportInView->specs ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label">Transmission</div><div class="item-value">{{ $reportInView->transmission ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Horse Power</div><div class="item-value">{{ $reportInView->horsepower ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label">Color</div><div class="item-value">{{ $reportInView->color ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Warranty</div><div class="item-value">{{ $reportInView->warrantyAvailable ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label">Service History</div><div class="item-value">{{ $reportInView->serviceHistory ?? 'N/A' }}</div></td>
                        <td><div class="item-label">No Of Keys</div><div class="item-value">{{ $reportInView->noOfKeys ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label">Mortgage</div><div class="item-value">{{ $reportInView->mortgage ?? 'N/A' }}</div></td>
                        <td><div class="item-label">Warranty</div><div class="item-value">{{ $reportInView->warrantyAvailable ?? 'N/A' }}</div></td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Dynamic Sections Loop --}}
        @php
        $sections = [
            'Exterior' => ['icon' => 'fa-solid fa-brush', 'fields' => ['paintCondition', 'convertible', 'blindSpot', 'sideSteps', 'wheelsType', 'rimsSizeFront', 'rimsSizeRear']],
            'Tires' => ['icon' => 'fa-solid fa-circle-dot', 'fields' => ['tiresSize', 'spareTire', 'frontLeftTire', 'frontRightTire', 'rearLeftTire', 'rearRightTire']],
            'Car Specs' => ['icon' => 'fa-solid fa-sliders', 'fields' => ['parkingSensors', 'keylessStart', 'seats', 'cooledSeats', 'heatedSeats', 'powerSeats', 'viveCamera', 'sunroofType', 'drive']],
            'Interior & Electrical' => ['icon' => 'fa-solid fa-bolt', 'fields' => ['speedmeterCluster', 'headLining', 'seatControls', 'seatsCondition', 'centralLockOperation', 'sunroofCondition', 'windowsControl', 'cruiseControl', 'acCooling']],
            'Engine & Transmission' => ['icon' => 'fa-solid fa-gears', 'fields' => ['engineCondition', 'transmissionCondition', 'engineNoise', 'engineSmoke', 'fourWdSystemCondition', 'obdError', 'engineOil', 'gearOil']],
            'Steering, Suspension & Brakes' => ['icon' => 'fa-solid fa-car-burst', 'fields' => ['steeringOperation', 'wheelAlignment', 'brakePads', 'suspension', 'brakeDiscs', 'shockAbsorberOperation']],
        ];

        // Keywords for status pill styling
        $good_keywords = ['good', 'operational', 'ok', 'normal', 'passed', 'yes'];
        $warning_keywords = ['fair', 'average', 'minor'];
        @endphp

        @foreach($sections as $sectionName => $sectionDetails)
            @php
            $sectionData = [];
            foreach ($sectionDetails['fields'] as $field) {
                if (isset($reportInView->{$field}) && $reportInView->{$field} !== '' && $reportInView->{$field} !== null) {
                    $sectionData[$field] = $reportInView->{$field};
                }
            }
            @endphp

            @if(!empty($sectionData))
            <div class="report-card">
                <div class="card-header"><i class="{{ $sectionDetails['icon'] }}"></i>{{ $sectionName }}</div>
                <div class="card-body">
                    <table class="details-table">
                        @foreach(array_chunk($sectionData, 2, true) as $chunk)
                        <tr>
                            @foreach($chunk as $field => $data)
                            <td>
                                <div class="item-label">{{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                @php $value_lower = is_string($data) ? strtolower($data) : ''; @endphp

                                @if(is_array($data))
                                    <div class="item-value"><ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul></div>
                                @elseif(in_array($value_lower, $good_keywords))
                                    <div class="status-pill status-good">{{ $data }}</div>
                                @elseif(in_array($value_lower, $warning_keywords))
                                    <div class="status-pill status-warning">{{ $data }}</div>
                                @elseif($value_lower != '')
                                    {{-- Use danger for other non-empty text values that aren't good/warning --}}
                                    <div class="status-pill status-danger">{{ $data }}</div>
                                @else
                                    <div class="item-value">{{ $data }}</div>
                                @endif
                            </td>
                            @endforeach
                            {{-- Add an empty cell if the row is not full --}}
                            @if(count($chunk) < 2) <td></td> @endif
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif
        @endforeach

        {{-- Car Damage View Section --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-triangle-exclamation"></i>Damage Assessment</div>
            <div class="card-body">
                <livewire:admin.inspection.car-damage-view :inspectionId="$reportInView->id" />
            </div>
        </div>

        <div class="footer">
            Vehicle Inspection Report &copy; {{ date('Y') }} Your Company Name. All Rights Reserved.
        </div>
    </div>
</body>

</html>