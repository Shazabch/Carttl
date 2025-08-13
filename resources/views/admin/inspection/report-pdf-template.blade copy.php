<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Inspection Report #{{ $reportInView->id }}</title>

    {{-- Google Fonts & Font Awesome for Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- Customizable CSS Variables --- */
        :root {
            /*
            * IMPORTANT: Change this color to your brand's primary color.
            */
            --primary-color: #d7b236; /* <--- YOUR COLOR CODE HERE */
            --primary-light: rgba(215, 178, 54, 0.1);
            --primary-dark: #b5972d;

            --font-family: 'Inter', 'Helvetica', sans-serif;
            --border-color: #e0e0e0;
            --background-light: #f9f9f9;
            --text-dark: #222;
            --text-muted: #666;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05);

            /* Status Pill Colors */
            --status-good-bg: #e6f7ee;
            --status-good-text: #0a6e3d;
            --status-warning-bg: #fff8e6;
            --status-warning-text: #8a6d3b;
            --status-danger-bg: #fde8e8;
            --status-danger-text: #c53030;
        }

        body {
            font-family: var(--font-family);
            font-size: 12px;
            color: var(--text-dark);
            background-color: #fff;
            line-height: 1.5;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Premium Header --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 120px;
            height: 3px;
            background: var(--primary-color);
        }
        .header-logo {
            flex: 0 0 auto;
        }
        .header-logo img {
            max-width: 180px;
            max-height: 60px;
            object-fit: contain;
        }
        .header-details {
            text-align: right;
        }
        .header-details h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }
        .header-meta {
            display: flex;
            gap: 15px;
            margin-top: 8px;
            font-size: 11px;
            color: var(--text-muted);
        }
        .header-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* --- Premium Card Sections --- */
        .report-card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 25px;
            page-break-inside: avoid;
            overflow: hidden;
            background: #fff;
            box-shadow: var(--shadow-sm);
        }
        .card-header {
            background: linear-gradient(to right, var(--primary-light), white);
            color: var(--text-dark);
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header .fa-solid {
            color: var(--primary-color);
            font-size: 14px;
        }
        .card-body {
            padding: 20px;
        }

        /* --- Premium Table Layout --- */
        .details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        .details-table tr:nth-child(even) td {
            background-color: var(--background-light);
        }
        .details-table td {
            padding: 12px 15px;
            vertical-align: middle;
            border: none;
            border-radius: 4px;
        }
        .details-table tr:first-child td {
            padding-top: 0;
        }

        /* --- Label/Value Pairs --- */
        .item-label {
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .item-label .fa-solid {
            font-size: 12px;
            color: var(--primary-color);
            opacity: 0.8;
        }
        .item-value {
            font-weight: 400;
            font-size: 13px;
            padding: 8px 0;
            line-height: 1.4;
        }
        .item-value-list {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .item-value-list li {
            background-color: #f0f0f0;
            color: #555;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        /* --- Enhanced Status Pills --- */
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
            box-shadow: var(--shadow-sm);
            gap: 6px;
        }
        .status-pill .fa-solid {
            font-size: 10px;
        }
        .status-good {
            background-color: var(--status-good-bg);
            color: var(--status-good-text);
        }
        .status-good .fa-solid {
            color: var(--status-good-text);
        }
        .status-warning {
            background-color: var(--status-warning-bg);
            color: var(--status-warning-text);
        }
        .status-warning .fa-solid {
            color: var(--status-warning-text);
        }
        .status-danger {
            background-color: var(--status-danger-bg);
            color: var(--status-danger-text);
        }
        .status-danger .fa-solid {
            color: var(--status-danger-text);
        }

        /* --- Premium Footer --- */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 15px 0;
            font-size: 10px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
        }
        .footer-brand {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* --- Print Optimization --- */
        @media print {
            body {
                font-size: 11pt;
            }
            .footer {
                position: fixed;
            }
            .report-card {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">
                {{-- IMPORTANT: Update the src path to your logo --}}
                <img src="{{asset('images/golden-x.png')}}" alt="Company Logo">
            </div>
            <div class="header-details">
                <h1>Vehicle Inspection Report</h1>
                <div class="header-meta">
                    <span><i class="fas fa-file-alt"></i> Report #{{ $reportInView->id }}</span>
                    <span><i class="fas fa-calendar"></i> {{ $reportInView->created_at->format('F d, Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Vehicle Information Card --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-car"></i>Vehicle Information</div>
            <div class="card-body">
                <table class="details-table">
                    <tr>
                        <td><div class="item-label"><i class="fas fa-tag"></i> Make</div><div class="item-value">{{ $reportInView->brand?->name ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-list-alt"></i> Trim</div><div class="item-value">{{ $reportInView->vehicleModel?->name ?? 'N/A' }}</div></td>
                    </tr>
                     <tr>
                        <td><div class="item-label"><i class="fas fa-calendar"></i> Year</div><div class="item-value">{{ $reportInView->year ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-barcode"></i> VIN</div><div class="item-value">{{ $reportInView->vin ?? 'N/A' }}</div></td>
                    </tr>
                     <tr>
                        <td><div class="item-label"><i class="fas fa-tachometer-alt"></i> Odometer</div><div class="item-value">{{ $reportInView->getOdometerLabelAttribute() ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-palette"></i> Color</div><div class="item-value">{{ $reportInView->color ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label"><i class="fas fa-cog"></i> No of Cylender</div><div class="item-value">{{ $reportInView->noOfCylinders ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-car-side"></i> Body Type</div><div class="item-value">{{ $reportInView->body_type ?? 'N/A' }}</div></td>
                    </tr>
                     <tr>
                        <td><div class="item-label"><i class="fas fa-map-marker-alt"></i> Registered Emirates</div><div class="item-value">{{ $reportInView->registeredEmirates ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-sliders-h"></i> Specs</div><div class="item-value">{{ $reportInView->specs ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label"><i class="fas fa-cogs"></i> Transmission</div><div class="item-value">{{ $reportInView->transmission ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-horse"></i> Horse Power</div><div class="item-value">{{ $reportInView->horsepower ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label"><i class="fas fa-palette"></i> Color</div><div class="item-value">{{ $reportInView->color ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-shield-alt"></i> Warranty</div><div class="item-value">{{ $reportInView->warrantyAvailable ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label"><i class="fas fa-history"></i> Service History</div><div class="item-value">{{ $reportInView->serviceHistory ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-key"></i> No Of Keys</div><div class="item-value">{{ $reportInView->noOfKeys ?? 'N/A' }}</div></td>
                    </tr>
                    <tr>
                        <td><div class="item-label"><i class="fas fa-file-invoice-dollar"></i> Mortgage</div><div class="item-value">{{ $reportInView->mortgage ?? 'N/A' }}</div></td>
                        <td><div class="item-label"><i class="fas fa-shield-alt"></i> Warranty</div><div class="item-value">{{ $reportInView->warrantyAvailable ?? 'N/A' }}</div></td>
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
                                <div class="item-label">
                                    <i class="fas fa-circle-notch"></i>
                                    {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}
                                </div>
                                @php $value_lower = is_string($data) ? strtolower($data) : ''; @endphp

                                @if(is_array($data))
                                    <div class="item-value"><ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul></div>
                                @elseif(in_array($value_lower, $good_keywords))
                                    <div class="status-pill status-good"><i class="fas fa-check-circle"></i>{{ $data }}</div>
                                @elseif(in_array($value_lower, $warning_keywords))
                                    <div class="status-pill status-warning"><i class="fas fa-exclamation-circle"></i>{{ $data }}</div>
                                @elseif($value_lower != '')
                                    <div class="status-pill status-danger"><i class="fas fa-times-circle"></i>{{ $data }}</div>
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
            <span class="footer-brand">Your Company Name</span> &copy; {{ date('Y') }} | Vehicle Inspection Report
        </div>
    </div>
</body>
</html>