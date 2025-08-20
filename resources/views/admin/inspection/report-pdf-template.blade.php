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
    <link rel="stylesheet" href="{{ asset('css/inspection.css') }}">
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

        /* This is the main table container for the header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        /* This recreates the accent line using a pseudo-element on the table */
        .header-table::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 120px;
            height: 3px;
            background: var(--primary-color);
        }

        /* Style the table cells */
        .header-logo-cell,
        .header-details-cell {
            padding: 0;
            border: none;
        }

        /* Style the logo image within its cell */
        .header-logo-img {
            max-width: 180px;
            max-height: 60px;
            object-fit: contain;
            display: block;
            /* Helps remove extra space below the image */
        }

        /* Keep the existing styles for the details section */
        .header-details-cell h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .header-details-cell .header-meta {
            display: block;
            /* Use block instead of flex */
            margin-top: 8px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .header-details-cell .header-meta span {
            display: inline-block;
            /* Use inline-block for spacing */
            margin-left: 15px;
            align-items: center;
            gap: 5px;
            /* Note: gap might not work in dompdf, margin is safer */
        }

        .header-details-cell .header-meta span:first-child {
            margin-left: 0;
        }

        /* ==================================================================== */
        /* == END: NEW HEADER CSS == */
        /* ==================================================================== */
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
            grid-template-columns: repeat(3, 1fr);
            /* exactly 3 per row */
            gap: 20px;
            margin-top: 15px;
        }

        .gallery-item {
            position: relative;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            margin: 5px;
            width: 300px !important;
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

        /* ==================================================================== */
        /* == START: PDF Page Layout Fix for Empty First Page == */
        /* ==================================================================== */

        @page {
            /* Define the physical page margins. This is where the fixed header/footer will live. */
            margin: 110px 25px 60px 25px;
            /* Top, Right, Bottom, Left */
        }

        header {
            position: fixed;
            top: -100px;
            /* Pull the header up into the top margin area */
            left: 0px;
            right: 0px;
            height: 90px;
            /* The approximate height of your header content */
        }

        footer {
            position: fixed;
            bottom: -50px;
            /* Pull the footer down into the bottom margin area */
            left: 0px;
            right: 0px;
            height: 40px;
            /* The approximate height of your footer content */
        }

        /* Optional: Add a page number counter */
        footer .page-number:after {
            content: "Page " counter(page);
        }

        /* This ensures the main content flows correctly and doesn't start on page 2 */
        main {
            position: relative;
            /* No top/bottom padding needed here because the @page margin handles it */
        }

        /* ==================================================================== */
        /* == END: PDF Page Layout Fix == */
        /* ==================================================================== */
    </style>
</head>

<body>
    <div class="">
        <!-- ==================================================================== -->
        <!-- == START: REFACTORED HEADER (Use this for both web and PDF) == -->
        <!-- ==================================================================== -->
        <table class="header-table" width="100%">
            <tr>
                <td class="header-logo-cell" valign="bottom">
                    <img src="{{ asset('images/golden-x.png') }}" alt="Golden X Logo" class="header-logo-img">
                </td>
                <td class="header-details-cell" valign="bottom" align="right">
                    <h1>Vehicle Inspection Report</h1>
                    <div class="header-meta">
                        <span><i class="fas fa-file-alt"></i> Report #{{ $reportInView->id }}</span>
                        <span><i class="fas fa-calendar"></i> Generated on {{ now()->format('M d, Y g:i A') }}</span>
                    </div>
                </td>
            </tr>
        </table>
        <!-- ==================================================================== -->
        <!-- == END: REFACTORED HEADER == -->
        <!-- ==================================================================== -->

        @php
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
                            <div class="item-value">{{ $reportInView->odometer.' kms' ?? 'N/A' }}</div>
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
                    <!-- <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['is_inspection'] ?? 'fas fa-circle-notch' }}"></i> Inspection</div>
                            <div class="item-value">{{ $reportInView->is_inspection ?? 'N/A' }}</div>
                        </td>
                        <td></td>
                    </tr> -->
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
        'fields' => ['frontLeftTire', 'frontRightTire', 'rearLeftTire', 'rearRightTire', 'tiresSize', 'spareTire','commentTire']
        ],
        'Car Specs' => [
        'icon' => 'fa-solid fa-sliders',
        'fields' => ['parkingSensors', 'keylessStart', 'seats', 'cooledSeats', 'heatedSeats', 'powerSeats', 'viveCamera', 'sunroofType', 'drive','blindSpot','headsDisplay','premiumSound','carbonFiber']
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

        {{-- Premium Image Gallery Section (Table-based for DomPDF) --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-images"></i>Vehicle Images</div>
            <div class="card-body image-gallery">

                @php
                $vehicleImages = $reportInView->images ?? collect();
                // Ensure we always have a collection to chunk
                if (!($vehicleImages instanceof \Illuminate\Support\Collection)) {
                $vehicleImages = collect($vehicleImages ?: []);
                }
                @endphp

                @if($vehicleImages->count())
                <table width="100%" cellspacing="0" cellpadding="8" style="border-collapse: collapse;">
                    @foreach($vehicleImages->chunk(3) as $row)
                    <tr>
                        @foreach($row as $image)
                        <td width="33.33%" valign="top" style="border: 1px solid #e0e0e0; border-radius: 8px;">
                            <div style="margin: 4px;">
                                <img
                                    src="{{ asset('storage/' . $image->path) }}"
                                    alt="{{ $image['title'] ?? 'Vehicle Image' }}"
                                    style="display: block; width: 100%; height: 180px; object-fit: cover; border-radius: 6px;">
                                <div style="margin-top: 6px; border-top: 1px solid #f0f0f0; padding-top: 6px;">
                                    <div style="font-size: 12px; font-weight: 600; color: #222;">
                                        <i class="fas fa-camera" style="color: #d7b236;"></i>
                                        Vehicle Image #{{$loop->iteration}}
                                    </div>
                                    <div style="font-size: 10px; color: #666; margin-top: 2px;">
                                        <i class="fas fa-clock"></i>
                                        {{ isset($image->created_at) ? \Carbon\Carbon::parse($image['created_at'])->format('M d, Y') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endforeach

                        {{-- Fill remaining cells if row has fewer than 3 items --}}
                        @for($i = $row->count(); $i < 3; $i++)
                            <td width="33.33%">
                            </td>
                            @endfor
                    </tr>
                    @endforeach
                </table>
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
                <livewire:admin.inspection.car-damage-view :inspectionId="$reportInView->id" />
            </div>
        </div>

        <div class="footer">
            <span class="footer-brand">Golden X</span> &copy; {{ date('Y') }} | Vehicle Inspection Report
        </div>
    </div>
</body>

</html>