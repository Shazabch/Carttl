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
            /* background-color: var(--background-light); */
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

        .disclaimer-text {
            text-align: justify;
            line-height: 1.5;
            /* Better readability */
            font-size: 14px;
            /* Adjust for print */
            margin: 0;
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
        'final_conclusion' => 'fas fa-clipboard',
        ];
        @endphp

        {{-- Basic Vehicle Information Card - Show ALL fields --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-car"></i>Basic Vehicle Information</div>
            <div class="card-body">
                <table class="details-table">
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['make'] ?? 'fas fa-circle-notch' }}"></i> Make </div>
                            <div class="item-value">{{ $reportInView->brand?->name ?? 'N/A' }}</div>

                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['model'] ?? 'fas fa-circle-notch' }}"></i> Model</div>
                            <div class="item-value">{{ $reportInView->vehicleModel?->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['trim'] ?? 'fas fa-circle-notch' }}"></i> Trim</div>
                            <div class="item-value">{{ $reportInView->trim ?? 'N/A' }}</div>
                        </td>

                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['year'] ?? 'fas fa-circle-notch' }}"></i> Year</div>
                            <div class="item-value">{{ $reportInView->year ?? 'N/A' }}</div>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['vin'] ?? 'fas fa-circle-notch' }}"></i> VIN</div>
                            <div class="item-value">{{ $reportInView->vin ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['odometer'] ?? 'fas fa-circle-notch' }}"></i> Mileage/Odometer</div>
                            <div class="item-value">{{ $reportInView->odometer.' kms' ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['engine_cc'] ?? 'fas fa-circle-notch' }}"></i> Engine CC</div>
                            <div class="item-value">{{ $reportInView->engine_cc ?? 'N/A' }}</div>
                        </td>

                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['horsepower'] ?? 'fas fa-circle-notch' }}"></i> Horsepower</div>
                            <div class="item-value">{{ $reportInView->horsepower ?? 'N/A' }}</div>
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
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons['noOfCylinders'] ?? 'fas fa-circle-notch' }}"></i> No. of Cylinders</div>
                            <div class="item-value">{{ $reportInView->noOfCylinders ?? 'N/A' }}</div>
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

        @php
        // These variables are now only needed for the hardcoded logic inside the template.
        $columnsPerRow = 5;

        // It's still helpful to have the icons in one place.
        $fieldIcons = [
        'paintCondition' => 'fa-solid fa-spray-can',
        'convertible' => 'fa-solid fa-car',
        'blindSpot' => 'fa-solid fa-car-on',
        'sideSteps' => 'fa-solid fa-shoe-prints',
        'wheelsType' => 'fa-solid fa-circle-dot',
        'rimsSizeFront' => 'fa-solid fa-arrows-left-right',
        'rimsSizeRear' => 'fa-solid fa-arrows-left-right',
        'engineOil' => 'fa-solid fa-oil-can',
        'gearOil' => 'fa-solid fa-gear',
        'gearshifting' => 'fa-solid fa-gears',
        'engineNoise' => 'fa-solid fa-volume-high',
        'engineSmoke' => 'fa-solid fa-smog',
        'fourWdSystemCondition' => 'fa-solid fa-car-side',
        'obdError' => 'fa-solid fa-triangle-exclamation',
        'remarks' => 'fa-solid fa-comment-dots',
        'frontLeftTire' => 'fa-solid fa-circle-dot',
        'frontRightTire' => 'fa-solid fa-circle-dot',
        'rearLeftTire' => 'fa-solid fa-circle-dot',
        'rearRightTire' => 'fa-solid fa-circle-dot',
        'tiresSize' => 'fa-solid fa-ruler-combined',
        'spareTire' => 'fa-solid fa-life-ring',
        'commentTire' => 'fa-solid fa-comment',
        'parkingSensors' => 'fa-solid fa-car-burst',
        'keylessStart' => 'fa-solid fa-key',
        'seats' => 'fa-solid fa-chair',
        'cooledSeats' => 'fa-solid fa-snowflake',
        'heatedSeats' => 'fa-solid fa-fire',
        'powerSeats' => 'fa-solid fa-bolt',
        'viveCamera' => 'fa-solid fa-camera-retro',
        'sunroofType' => 'fa-solid fa-sun',
        'drive' => 'fa-solid fa-road',
        'headsDisplay' => 'fa-solid fa-desktop',
        'premiumSound' => 'fa-solid fa-music',
        'carbonFiber' => 'fa-solid fa-cubes',
        'speedmeterCluster' => 'fa-solid fa-gauge-high',
        'headLining' => 'fa-solid fa-arrow-up',
        'seatControls' => 'fa-solid fa-toggle-on',
        'seatsCondition' => 'fa-solid fa-check-double',
        'centralLockOperation' => 'fa-solid fa-lock',
        'sunroofCondition' => 'fa-solid fa-sun',
        'windowsControl' => 'fa-solid fa-window-maximize',
        'cruiseControl' => 'fa-solid fa-forward',
        'acCooling' => 'fa-solid fa-wind',
        'comment_section2' => 'fa-solid fa-comments',
        'steeringOperation' => 'fa-solid fa-dharmachakra',
        'wheelAlignment' => 'fa-solid fa-arrows-to-dot',
        'brakePads' => 'fa-solid fa-compact-disc',
        'suspension' => 'fa-solid fa-car-burst',
        'brakeDiscs' => 'fa-solid fa-compact-disc',
        'shockAbsorberOperation' => 'fa-solid fa-car-burst',
        'comment_section1' => 'fa-solid fa-comments',
        ];
        @endphp


        {{-- ==================================================================== --}}
        {{-- == 1. Exterior Section                                            == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-brush"></i>Exterior</div>
            <div class="card-body">
                <table class="details-table">
                    {{-- Special full-width row for Paint Condition --}}
                    <tr>
                        <td colspan="{{ $columnsPerRow }}">
                            @php $field = 'paintCondition'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                    </tr>
                    {{-- Row 1 of other fields --}}
                    <tr>

                    </tr>
                    {{-- Row 2 of other fields --}}

                </table>
            </div>
        </div>


        {{-- ==================================================================== --}}
        {{-- == 2. Damage Assessment Section                                   == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <livewire:admin.inspection.car-damage-view :inspectionId="$reportInView->id" />
        </div>


        {{-- ==================================================================== --}}
        {{-- == 3. Engine & Transmission Section                               == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-gears"></i>Engine & Transmission</div>
            <div class="card-body">
                <table class="details-table">
                    {{-- Row 1 --}}
                    <tr>
                        @foreach(['engineOil', 'gearOil', 'gearshifting', 'engineNoise', 'engineSmoke'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                    </tr>
                    {{-- Row 2 --}}
                    <tr>
                        @foreach(['fourWdSystemCondition', 'obdError'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                        <td></td>
                        <td></td>
                        <td></td> {{-- 3 empty cells --}}
                    </tr>
                    {{-- Full-width row for Remarks --}}
                    <tr>
                        <td colspan="{{ $columnsPerRow }}">
                            @php $field = 'remarks'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        {{-- ==================================================================== --}}
        {{-- == 4. Tires Section                                               == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-circle-dot"></i>Tires</div>
            <div class="card-body">
                <table class="details-table">
                    {{-- Row 1 --}}
                    <tr>
                        @foreach(['frontLeftTire', 'frontRightTire', 'rearLeftTire', 'rearRightTire', 'tiresSize'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                    </tr>
                    {{-- Row 2 --}}
                    <tr>
                        @foreach(['spareTire','wheelsType', 'rimsSizeFront','rimsSizeRear'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                        <td></td>

                    </tr>
                    {{-- Full-width row for Tire Comments --}}
                    <tr>
                        <td colspan="{{ $columnsPerRow }}">
                            @php $field = 'commentTire'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> Comments</div>
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        {{-- ==================================================================== --}}
        {{-- == 5. Car Specs Section                                           == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-sliders"></i>Car Specs</div>
            <div class="card-body">
                <table class="details-table">
                    <tr>
                        @foreach(['parkingSensors', 'keylessStart', 'seats', 'cooledSeats', 'heatedSeats'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach(['powerSeats', 'viveCamera', 'sunroofType', 'drive','blindSpot'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach(['headsDisplay','premiumSound','carbonFiber','convertible','sideSteps'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach

                    </tr>
                    <tr>
                        @foreach(['soft_door_closing'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-door-closed' }} text-primary"></i> Soft Door Closing</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                   
                </table>
            </div>
        </div>


        {{-- ==================================================================== --}}
        {{-- == 6. Interior, Electrical & Air Conditioner Section              == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-bolt"></i>Interior, Electrical & Air Conditioner</div>
            <div class="card-body">
                <table class="details-table">
                    {{-- Row 1 --}}
                    <tr>
                        @foreach(['speedmeterCluster', 'headLining', 'seatControls', 'seatsCondition', 'centralLockOperation'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                    </tr>
                    {{-- Row 2 --}}
                    <tr>
                        @foreach(['sunroofCondition', 'windowsControl', 'cruiseControl', 'acCooling'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                        <td></td> {{-- 1 empty cell --}}
                    </tr>
                    {{-- Full-width row for Comments --}}
                    <tr>
                        <td colspan="{{ $columnsPerRow }}">
                            @php $field = 'comment_section2'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> Comments</div>
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        {{-- ==================================================================== --}}
        {{-- == 7. Steering, Suspension & Brakes Section                       == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-car-burst"></i>Steering, Suspension & Brakes</div>
            <div class="card-body">
                <table class="details-table">
                    {{-- Row 1 --}}
                    <tr>
                        @foreach(['steeringOperation', 'wheelAlignment', 'brakePads', 'suspension', 'brakeDiscs'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                    </tr>
                    {{-- Row 2 --}}
                    <tr>
                        @foreach(['shockAbsorberOperation'] as $field)
                        <td>
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                        @endforeach
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td> {{-- 4 empty cells --}}
                    </tr>
                    {{-- Full-width row for Comments --}}
                    <tr>
                        <td colspan="{{ $columnsPerRow }}">
                            @php $field = 'comment_section1'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> Comments</div>
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- ==================================================================== --}}
        {{-- == 5. Final Conclusion Section                                           == --}}
        {{-- ==================================================================== --}}
        <div class="report-card">
            <div class="card-header"><i class="fa-solid fa-clipboard"></i>Final Conclusion</div>
            <div class="card-body">
                <table class="details-table">
                    <tr>
                        <td colspan="{{ $columnsPerRow }}">
                            @php $field = 'final_conclusion'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-flag'  }} text-primary"></i> Final Conclusion</div>
                            @if(is_array($data)) <div class="item-value">
                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else <div class="item-value">{{ $data }}</div> @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
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

                $imageNum=1;
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
                                        Vehicle Image #{{$imageNum}}
                                    </div>
                                    <div style="font-size: 10px; color: #666; margin-top: 2px;">
                                        <i class="fas fa-clock"></i>
                                        {{ isset($image->created_at) ? \Carbon\Carbon::parse($image['created_at'])->format('M d, Y') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        @php
                        $imageNum++;

                        @endphp
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


        <!-- disclaimer -->
        <div class="report-card">
            <!-- <div class="card-header"><i class="fa-solid fa-car"></i>Basic Vehicle Information</div> -->
            <div class="card-body">
                <table class="details-table">

                    <tr>
                        <td>
                            <div class="item-label">Disclaimer </div>
                            <div class="item-value">
                                <p class="disclaimer-text">
                                    The inspection is strictly limited to the items listed in this Inspection Report and does not
                                    cover any other items. 2. The inspection is visual and non-mechanical only. If you wish to
                                    complete a mechanical inspection or an inspection of the internal parts of the vehicle,
                                    Golden X encourages you to contact a different service provider who undertakes that type
                                    of inspection. 3. Golden X does not inspect historic service records or accident records for
                                    the vehicle, and does not check whether the vehicle is subject to a recall notice. 4. While
                                    Golden X uses accepted methods for inspecting the vehicle, these methods do not
                                    necessarily identify all faults with the vehicle. In particular, the inspection does not cover
                                    intermittent problems which are not apparent at the time of the inspection. 5. This
                                    Inspection Report, and all intellectual property rights therein, will remain the exclusive
                                    property of Golden X. 6. This Inspection Report represents Golden X subjective opinion as to
                                    the condition of the vehicle (limited to the specific items listed in this Inspection Report),
                                    considering the age and condition of the vehicle at the time of inspection and based on the
                                    Golden Xinspector’s knowledge and experience. This Inspection Report is designed to assist
                                    you to make decisions based on the general condition of the vehicle only. Golden X will not
                                    provide a recommendation as to whether to sell or purchase the vehicle. 7. Golden X can
                                    only advise on the condition of the vehicle at the time of the inspection, and this Inspection
                                    Report is only current as at the time it is issued. If you are considering purchasing the
                                    vehicle, it is your responsibility to conduct a further inspection of the vehicle at the time of
                                    purchase. 8. This Inspection Report is provided by Golden X ‘as is’ for your information only,
                                    without any warranties whatsoever. In particular, Golden X does not provide any warranty
                                    regarding the accuracy or completeness of any information contained in this Inspection
                                    Report, or the fitness of the information contained in this Inspection Report for any purpose
                                    intended. 9. If this Inspection Report is provided to you directly by Golden X, only you may
                                    rely on the content of this Inspection Report, and Golden X does not accept any liability
                                    whatsoever to any third-party you may choose to share this Inspection Report with. 10. If
                                    this Inspection Report is provided to you by someone else than Golden X, you may not rely
                                    on the content of this Inspection Report, and Golden X does not accept any liability
                                    whatsoever to you in connection with this Inspection Report.
                                </p>
                            </div>
                        </td>


                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <span class="footer-brand">Golden X</span> &copy; {{ date('Y') }} | Vehicle Inspection Report
        </div>
    </div>
</body>

</html>