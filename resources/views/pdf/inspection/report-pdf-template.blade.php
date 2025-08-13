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
            --primary-color: #d7b236;
            --primary-light: rgba(215, 178, 54, 0.1);
            --primary-dark: #b5972d;

            --font-family: 'Inter', 'Helvetica', sans-serif;
            --border-color: #e0e0e0;
            --background-light: #f9f9f9;
            --text-dark: #222;
            --text-muted: #666;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.05);

            /* Enhanced Status Colors */
            --status-excellent-bg: #e8f5e8;
            --status-excellent-text: #2d5a2d;
            --status-good-bg: #e6f7ee;
            --status-good-text: #0a6e3d;
            --status-warning-bg: #fff8e6;
            --status-warning-text: #8a6d3b;
            --status-danger-bg: #fde8e8;
            --status-danger-text: #c53030;
            --status-info-bg: #e6f3ff;
            --status-info-text: #1a5490;
            --status-na-bg: #f5f5f5;
            --status-na-text: #888;
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

        /* --- Premium Header with Golden X Placeholder --- */
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
            position: relative;
        }

        .header-logo img {
            max-width: 180px;
            max-height: 60px;
            object-fit: contain;
        }

        /* Golden X Placeholder */
        .golden-x-placeholder {
            width: 180px;
            height: 60px;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: white;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 2px;
            box-shadow: var(--shadow-md);
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
            padding: 8px 12px;
            line-height: 1.4;
            background-color: var(--background-light);
            border-radius: 4px;
            border: 1px solid var(--border-color);
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

        /* --- Enhanced Status Pills with Colors --- */
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

        /* Excellent Status */
        .status-excellent {
            background-color: var(--status-excellent-bg);
            color: var(--status-excellent-text);
        }

        .status-excellent .fa-solid {
            color: var(--status-excellent-text);
        }

        /* Good Status */
        .status-good {
            background-color: var(--status-good-bg);
            color: var(--status-good-text);
        }

        .status-good .fa-solid {
            color: var(--status-good-text);
        }

        /* Warning Status */
        .status-warning {
            background-color: var(--status-warning-bg);
            color: var(--status-warning-text);
        }

        .status-warning .fa-solid {
            color: var(--status-warning-text);
        }

        /* Danger Status */
        .status-danger {
            background-color: var(--status-danger-bg);
            color: var(--status-danger-text);
        }

        .status-danger .fa-solid {
            color: var(--status-danger-text);
        }

        /* Info Status */
        .status-info {
            background-color: var(--status-info-bg);
            color: var(--status-info-text);
        }

        .status-info .fa-solid {
            color: var(--status-info-text);
        }

        /* N/A Status */
        .status-na {
            background-color: var(--status-na-bg);
            color: var(--status-na-text);
        }

        .status-na .fa-solid {
            color: var(--status-na-text);
        }

        /* --- Premium Image Gallery Styles --- */
        .image-gallery {
            padding: 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .gallery-item {
            position: relative;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            margin: 5px;

            box-shadow: var(--shadow-md);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .gallery-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .gallery-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .gallery-caption {
            padding: 12px 15px;
            background: linear-gradient(to right, var(--primary-light), white);
            border-top: 1px solid var(--border-color);
        }

        .gallery-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gallery-title .fa-solid {
            color: var(--primary-color);
            font-size: 12px;
        }

        .gallery-description {
            font-size: 11px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        .gallery-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #f0f0f0;
        }

        .gallery-timestamp {
            font-size: 10px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .gallery-category {
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 10px;
            background: var(--primary-color);
            color: white;
            font-weight: 500;
        }

        .no-images {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .no-images .fa-solid {
            font-size: 48px;
            color: var(--border-color);
            margin-bottom: 15px;
        }

        .no-images h3 {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 500;
        }

        .no-images p {
            margin: 0;
            font-size: 12px;
        }

        /* --- Damage Assessment Styles --- */
        .damage-assessment {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .damage-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .damage-item:last-child {
            border-bottom: none;
        }

        .damage-type {
            font-weight: 500;
            color: var(--text-dark);
        }

        .damage-location {
            color: var(--text-muted);
            font-size: 11px;
        }

        /* --- Premium Footer --- */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 15px 0;
            font-size: 10px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
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
                position: relative;
            }

            .report-card {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .damage-assessment {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .gallery-item {
                break-inside: avoid;
            }

            .gallery-image {
                height: 150px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">

                <img src="{{ public_path('images/golden-x.png') }}" alt="Golden X Logo">
            </div>

            <div class="header-details">
                <h1>Vehicle Inspection Report</h1>
                <div class="header-meta">
                    <span><i class="fas fa-file-alt"></i> Report #{{ $reportInView->id }}</span>
                    <span><i class="fas fa-calendar"></i> {{ $reportInView->created_at->format('F d, Y') }}</span>
                </div>
            </div>
        </div>

        @php
        // Helper function to get status class and icon
        function getStatusInfo($value) {
        if (is_array($value)) {
        return ['class' => 'item-value', 'icon' => 'fas fa-list'];
        }

        $value_lower = is_string($value) ? strtolower(trim($value)) : '';

        // Excellent conditions
        $excellent_keywords = ['excellent', 'perfect', 'like new'];
        foreach ($excellent_keywords as $keyword) {
        if (strpos($value_lower, $keyword) !== false) {
        return ['class' => 'status-excellent', 'icon' => 'fas fa-star'];
        }
        }

        // Good conditions
        $good_keywords = ['no visible fault', 'no leak', 'no error', 'no smoke', 'available', 'good', 'operational', 'working', 'functional', 'ok', 'normal', 'passed', 'yes'];
        foreach ($good_keywords as $keyword) {
        if (strpos($value_lower, $keyword) !== false) {
        return ['class' => 'status-good', 'icon' => 'fas fa-check-circle'];
        }
        }

        // Warning conditions
        $warning_keywords = ['minor leak', 'judder', 'cranking noise', 'white', 'minor error', 'stuck', 'worn', 'noisy', 'dirty', 'warning light on', 'fair', 'average', 'minor'];
        foreach ($warning_keywords as $keyword) {
        if (strpos($value_lower, $keyword) !== false) {
        return ['class' => 'status-warning', 'icon' => 'fas fa-exclamation-triangle'];
        }
        }

        // Danger conditions
        $danger_keywords = ['major leak', 'hard', 'tappet noise', 'abnormal noise', 'black', 'major error', 'not engaging', 'damaged', 'not working', 'not cooling', 'alignment out', 'worn out', 'arms-bushes crack', 'rusty', 'poor', 'bad', 'broken', 'failed'];
        foreach ($danger_keywords as $keyword) {
        if (strpos($value_lower, $keyword) !== false) {
        return ['class' => 'status-danger', 'icon' => 'fas fa-times-circle'];
        }
        }

        // N/A or empty
        if (empty($value_lower) || $value_lower === 'n/a' || $value_lower === 'not available') {
        return ['class' => 'status-na', 'icon' => 'fas fa-minus-circle'];
        }

        // Default info status
        return ['class' => 'status-info', 'icon' => 'fas fa-info-circle'];
        }

        // Field icons mapping
        $fieldIcons = [
        'make' => 'fas fa-industry',
        'model' => 'fas fa-car',
        'year' => 'fas fa-calendar-alt',
        'vin' => 'fas fa-barcode',
        'odometer' => 'fas fa-tachometer-alt',
        'color' => 'fas fa-palette',
        'noOfCylinders' => 'fas fa-cog',
        'body_type' => 'fas fa-car-side',
        'registeredEmirates' => 'fas fa-map-marker-alt',
        'specs' => 'fas fa-sliders-h',
        'transmission' => 'fas fa-cogs',
        'horsepower' => 'fas fa-horse-head',
        'warrantyAvailable' => 'fas fa-shield-alt',
        'serviceHistory' => 'fas fa-history',
        'noOfKeys' => 'fas fa-key',
        'mortgage' => 'fas fa-file-invoice-dollar',
        'engine_cc' => 'fas fa-engine',
        'serviceContractAvailable' => 'fas fa-handshake',
        'is_inspection' => 'fas fa-search',
        // Engine fields
        'engineOil' => 'fas fa-oil-can',
        'gearOil' => 'fas fa-cog',
        'gearshifting' => 'fas fa-exchange-alt',
        'engineNoise' => 'fas fa-volume-up',
        'engineSmoke' => 'fas fa-smog',
        'fourWdSystemCondition' => 'fas fa-road',
        'obdError' => 'fas fa-exclamation-triangle',
        'remarks' => 'fas fa-comment',
        // Exterior fields
        'paintCondition' => 'fas fa-brush',
        'convertible' => 'fas fa-car-alt',
        'blindSpot' => 'fas fa-eye',
        'sideSteps' => 'fas fa-stairs',
        'wheelsType' => 'fas fa-circle',
        'rimsSizeFront' => 'fas fa-circle-notch',
        'rimsSizeRear' => 'fas fa-circle-notch',
        // Tires
        'frontLeftTire' => 'fas fa-circle',
        'frontRightTire' => 'fas fa-circle',
        'rearLeftTire' => 'fas fa-circle',
        'rearRightTire' => 'fas fa-circle',
        'tiresSize' => 'fas fa-ruler',
        'spareTire' => 'fas fa-life-ring',
        // Interior
        'speedmeterCluster' => 'fas fa-tachometer-alt',
        'headLining' => 'fas fa-home',
        'seatControls' => 'fas fa-chair',
        'seatsCondition' => 'fas fa-couch',
        'centralLockOperation' => 'fas fa-lock',
        'sunroofCondition' => 'fas fa-sun',
        'windowsControl' => 'fas fa-window-maximize',
        'cruiseControl' => 'fas fa-ship',
        'acCooling' => 'fas fa-snowflake',
        // Car Specs
        'parkingSensors' => 'fas fa-radar',
        'keylessStart' => 'fas fa-key',
        'seats' => 'fas fa-chair',
        'cooledSeats' => 'fas fa-snowflake',
        'heatedSeats' => 'fas fa-fire',
        'powerSeats' => 'fas fa-bolt',
        'viveCamera' => 'fas fa-camera',
        'sunroofType' => 'fas fa-sun',
        'drive' => 'fas fa-road',
        // Brakes
        'steeringOperation' => 'fas fa-steering-wheel',
        'wheelAlignment' => 'fas fa-crosshairs',
        'brakePads' => 'fas fa-stop-circle',
        'suspension' => 'fas fa-car-crash',
        'brakeDiscs' => 'fas fa-compact-disc',
        'shockAbsorberOperation' => 'fas fa-car-crash',
        'comment_section1' => 'fas fa-comment',
        'comment_section2' => 'fas fa-comment',
        ];
        @endphp

        {{-- Basic Vehicle Information Card - Show ALL fields --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-car"></i>Basic Vehicle Information</div>
            <div class="card-body">
                <table class="details-table">
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['make'] ?? 'fas fa-circle-notch' }}"></i> Make</div>
                            <div class="item-value">{{ $reportInView->brand?->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['model'] ?? 'fas fa-circle-notch' }}"></i> Model</div>
                            <div class="item-value">{{ $reportInView->vehicleModel?->name ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['year'] ?? 'fas fa-circle-notch' }}"></i> Year</div>
                            <div class="item-value">{{ $reportInView->year ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['vin'] ?? 'fas fa-circle-notch' }}"></i> VIN</div>
                            <div class="item-value">{{ $reportInView->vin ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['odometer'] ?? 'fas fa-circle-notch' }}"></i> Mileage/Odometer</div>
                            <div class="item-value">{{ $reportInView->getOdometerLabelAttribute() ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['engine_cc'] ?? 'fas fa-circle-notch' }}"></i> Engine CC</div>
                            <div class="item-value">{{ $reportInView->engine_cc ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['horsepower'] ?? 'fas fa-circle-notch' }}"></i> Horsepower</div>
                            <div class="item-value">{{ $reportInView->horsepower ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['noOfCylinders'] ?? 'fas fa-circle-notch' }}"></i> No. of Cylinders</div>
                            <div class="item-value">{{ $reportInView->noOfCylinders ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['color'] ?? 'fas fa-circle-notch' }}"></i> Color</div>
                            <div class="item-value">{{ $reportInView->color ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['specs'] ?? 'fas fa-circle-notch' }}"></i> Specs</div>
                            <div class="item-value">{{ $reportInView->specs ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['registeredEmirates'] ?? 'fas fa-circle-notch' }}"></i> Registered Emirates</div>
                            <div class="item-value">{{ $reportInView->registerEmirates ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['body_type'] ?? 'fas fa-circle-notch' }}"></i> Body Type</div>
                            <div class="item-value">{{ $reportInView->body_type ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['transmission'] ?? 'fas fa-circle-notch' }}"></i> Transmission</div>
                            <div class="item-value">{{ $reportInView->transmission ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['warrantyAvailable'] ?? 'fas fa-circle-notch' }}"></i> Warranty Available</div>
                            <div class="item-value">{{ $reportInView->warrantyAvailable ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['serviceContractAvailable'] ?? 'fas fa-circle-notch' }}"></i> Service Contract</div>
                            <div class="item-value">{{ $reportInView->serviceContractAvailable ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['serviceHistory'] ?? 'fas fa-circle-notch' }}"></i> Service History</div>
                            <div class="item-value">{{ $reportInView->serviceHistory ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['noOfKeys'] ?? 'fas fa-circle-notch' }}"></i> No Of Keys</div>
                            <div class="item-value">{{ $reportInView->noOfKeys ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['mortgage'] ?? 'fas fa-circle-notch' }}"></i> Mortgage</div>
                            <div class="item-value">{{ $reportInView->mortgage ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['is_inspection'] ?? 'fas fa-circle-notch' }}"></i> Inspection</div>
                            <div class="item-value">{{ $reportInView->is_inspection ?? 'N/A' }}</div>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Dynamic Sections Loop - Show ALL fields --}}
        @php
        $sections = [
        'Engine & Transmission' => [
        'icon' => 'fa-solid fa-gears',
        'fields' => ['engineOil', 'gearOil', 'gearshifting', 'engineNoise', 'engineSmoke', 'fourWdSystemCondition', 'obdError', 'remarks']
        ],
        'Exterior' => [
        'icon' => 'fa-solid fa-brush',
        'fields' => ['paintCondition', 'convertible', 'blindSpot', 'sideSteps', 'wheelsType', 'rimsSizeFront', 'rimsSizeRear']
        ],
        'Tires' => [
        'icon' => 'fa-solid fa-circle-dot',
        'fields' => ['frontLeftTire', 'frontRightTire', 'rearLeftTire', 'rearRightTire', 'tiresSize', 'spareTire']
        ],
        'Car Specs' => [
        'icon' => 'fa-solid fa-sliders',
        'fields' => ['parkingSensors', 'keylessStart', 'seats', 'cooledSeats', 'heatedSeats', 'powerSeats', 'viveCamera', 'sunroofType', 'drive']
        ],
        'Interior, Electrical & Air Conditioner' => [
        'icon' => 'fa-solid fa-bolt',
        'fields' => ['speedmeterCluster', 'headLining', 'seatControls', 'seatsCondition', 'centralLockOperation', 'sunroofCondition', 'windowsControl', 'cruiseControl', 'acCooling', 'comment_section2']
        ],
        'Steering, Suspension & Brakes' => [
        'icon' => 'fa-solid fa-car-burst',
        'fields' => ['steeringOperation', 'wheelAlignment', 'brakePads', 'suspension', 'brakeDiscs', 'shockAbsorberOperation', 'comment_section1']
        ],
        ];
        @endphp

        @foreach($sections as $sectionName => $sectionDetails)
        <div class="report-card">
            <div class="card-header"><i class="{{ $sectionDetails['icon'] }}"></i>{{ $sectionName }}</div>
            <div class="card-body">
                <table class="details-table">
                    @foreach(array_chunk($sectionDetails['fields'], 2) as $chunk)
                    <tr>
                        @foreach($chunk as $field)
                        <td>
                            <div class="item-label">
                                <i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i>
                                {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}
                            </div>
                            @php
                            $data = $reportInView->{$field} ?? 'N/A';
                            $statusInfo = getStatusInfo($data);
                            @endphp

                            @if(is_array($data))
                            <div class="item-value">
                                <ul class="item-value-list">
                                    @foreach($data as $value)
                                    <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value')
                            <div class="status-pill {{ $statusInfo['class'] }}">
                                <i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}
                            </div>
                            @else
                            <div class="item-value">{{ $data }}</div>
                            @endif
                        </td>
                        @endforeach
                        {{-- Add empty cell if odd number of fields --}}
                        @if(count($chunk) < 2) <td>
                            </td> @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach

        {{-- Premium Image Gallery Section --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-images"></i>Vehicle Images</div>
            <div class="card-body image-gallery">
                @php

                $vehicleImages = $reportInView->images;

                @endphp

                @if($reportInView->images)
                <div class="gallery-grid">
                    @foreach($reportInView->images as $image)

                    <div class="gallery-item">
                        <img src="{{ storage_path('app/public/' . $image->path) }}"
                            alt="{{ $image['title'] ?? 'Vehicle Image' }}"
                            class="gallery-image">
                        <div class="gallery-caption">
                            <h4 class="gallery-title">
                                <i class="fas fa-camera"></i>
                                {{ 'Vehicle Image' }}
                            </h4>
                            <div class="gallery-meta">
                                <span class="gallery-timestamp">
                                    <i class="fas fa-clock"></i>
                                    {{ isset($image->created_at) ? \Carbon\Carbon::parse($image['created_at'])->format('M d, Y') : 'N/A' }}
                                </span>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="no-images">
                    <i class="fas fa-image"></i>
                    <h3>No Images Available</h3>
                    <p>No vehicle images have been uploaded for this inspection report.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Car Damage View Section - Static Content for PDF --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-triangle-exclamation"></i>Damage Assessment</div>
            <div class="card-body">
                @include('pdf.inspection.damage-report', ['damages' => $reportInView->damages])
            </div>
        </div>

        <div class="footer">
            <span class="footer-brand">Golden X</span> &copy; {{ date('Y') }} | Vehicle Inspection Report | Generated on {{ now()->format('M d, Y g:i A') }}
        </div>
    </div>
</body>

</html>