<!DOCTYPE html>
<html lang="en">

<head>

    <title>Inspection Report #{{ $reportInView->id }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Google Fonts & Font Awesome for Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/inspection.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* White arrows for dark background */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: 100% 100%;
            width: 3rem;
            height: 3rem;
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M11 1 3 8l8 7V1z'/%3E%3C/svg%3E");
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M5 1l8 7-8 7V1z'/%3E%3C/svg%3E");
        }
    </style>

    <style>
        /* --- Customizable CSS Variables --- */
        :root {
            --primary-color: #c9da29;
            --primary-light: rgba(201, 218, 41, 0.15);
            --primary-dark: #a8b622;
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

        /* Accordion Open State - Lime Green */
        .accordion-button:not(.collapsed) {
            background-color: #c9da29 !important;
            color: #000 !important;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) i {
            color: #000 !important;
        }

        .accordion-button:hover {
            filter: brightness(110%);
        }

        body {
            font-family: var(--font-family);
            font-size: 13px;
            color: var(--text-dark);
            background-color: #fff;
            line-height: 1.6;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .container {
            padding: 0 15px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Header - Fully Responsive */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .header-table::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100px;
            height: 3px;
            background: var(--primary-color);
        }

        .header-logo-img {
            max-width: 160px;
            height: auto;
        }

        .header-details-cell h1 {
            font-size: 20px;
            margin: 10px 0 5px;
            font-weight: 700;
        }

        .header-meta {
            font-size: 11px;
            color: var(--text-muted);
        }

        .header-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 12px;
        }

        /* Cards & Sections */
        .report-card,
        .report-card-top {
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            page-break-inside: avoid;
        }

        .card-header,
        .card-header-top {
            font-size: 17px;
            font-weight: 700;
            padding: 14px 18px;
            background: var(--primary-color);
            color: #000;
        }

        .card-header i {
            margin-right: 10px;
            font-size: 18px;
        }

        .card-body,
        .card-body-top {
            padding: 20px;
        }

        /* Responsive Grid for Info Cards */
        .row>[class*="col-"] {
            padding: 6px 10px;
        }

        .main-col-class {
            border: 1px solid #dbd9d9;
        }

        .col-bg-class {
            background-color: var(--background-light);
        }

        .item-label {
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .item-label i {
            color: var(--primary-color);
            font-size: 14px;
        }

        .item-value {
            font-size: 14px;
            font-weight: 500;
            text-align: right;
            color: var(--text-dark);
        }

        /* Status Pills */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            float: right;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .status-excellent {
            background: var(--status-excellent-bg);
            color: var(--status-excellent-text);
        }

        .status-good {
            background: var(--status-good-bg);
            color: var(--status-good-text);
        }

        .status-warning {
            background: var(--status-warning-bg);
            color: var(--status-warning-text);
        }

        .status-danger {
            background: var(--status-danger-bg);
            color: var(--status-danger-text);
        }

        .status-info {
            background: var(--status-info-bg);
            color: var(--status-info-text);
        }

        .status-na {
            background: var(--status-na-bg);
            color: var(--status-na-text);
        }

        /* Vehicle Images - Mobile First */
        .card-body-top .row {
            margin: 0 -10px;
        }

        .card-body-top img {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .position-relative .position-absolute {
            border-radius: 0 0 12px 12px;
        }

        /* Damage Image & Table */
        .damage-assessment img {
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .details-table th {
            background: #c9da29;
            color: white;
            padding: 10px 8px;
            font-weight: 600;
            text-align: left;
        }

        .details-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 11px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            margin-top: 40px;
        }

        .footer-brand {
            color: var(--primary-color);
            font-weight: 700;
        }

        /* PDF Page Fix */
        @page {
            margin: 100px 20px 60px 20px;
        }

        header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            height: 80px;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
        }

        /* ======================================== */
        /* RESPONSIVE BREAKPOINTS - MOBILE FIRST    */
        /* ======================================== */
        @media (max-width: 768px) {
            .header-details-cell h1 {
                font-size: 18px;
            }

            .header-logo-img {
                max-width: 130px;
            }

            /* Stack vehicle info side-by-side → full width */
            .row>[class*="col-"] {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .main-col-class {
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
            }

            .col-6.main-col-class {
                border-bottom: none;
            }

            /* Image Gallery - Stack vertically */
            .gallery-grid {
                grid-template-columns: 1fr !important;
            }

            .card-body-top .col-md-8,
            .card-body-top .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .card-body-top .col-md-4 img {
                height: 150px !important;
            }

            /* Accordion headers bigger tap area */
            .accordion-button {
                padding: 16px 18px !important;
                font-size: 16px;
            }

            /* Status pills full width on mobile */
            .status-pill {
                float: none;
                display: block;
                text-align: center;
                margin-top: 8px;
            }

            /* Table responsive */
            .details-table,
            .details-table thead,
            .details-table tbody,
            .details-table th,
            .details-table td,
            .details-table tr {
                display: block;
            }

            .details-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .details-table tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
                border-radius: 8px;
                overflow: hidden;
            }

            .details-table td {
                border: none;
                position: relative;
                padding-left: 50% !important;
                text-align: right;
            }

            .details-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 12px;
                width: 45%;
                font-weight: bold;
                text-align: left;
                color: var(--primary-color);
            }
        }

        @media (max-width: 480px) {
            body {
                font-size: 12.5px;
            }

            .card-header,
            .card-header-top {
                font-size: 16px;
                padding: 12px 15px;
            }

            .item-label,
            .item-value {
                font-size: 13px;
            }

            .status-pill {
                font-size: 11px;
                padding: 5px 10px;
            }
        }

        /* DUBIZZLE OFFICIAL MOBILE NAVBAR - EXACT COPY */
        .dubizzle-mobile-nav {
            border-radius: 24px 24px 0 0;
            overflow: hidden;
            padding: 8px 4px 12px;
            background: rgba(255, 255, 255, 0.95) !important;
        }

        .dubizzle-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #8c8c8c;
            font-size: 10px;
            font-weight: 600;
            padding: 6px 2px;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            min-width: 0;
        }

        .dubizzle-nav-item .icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
            border-radius: 50%;
            background: transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .dubizzle-nav-item i {
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        /* ACTIVE STATE - DUBIZZLE ORANGE */
        .dubizzle-nav-item.active {
            color: #ff6b00 !important;
        }

        .dubizzle-nav-item.active .icon {
            background: #fff2e6;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.25);
            transform: scale(1.1);
        }

        .dubizzle-nav-item.active i {
            transform: translateY(-2px);
        }

        /* Active indicator dot */
        .dubizzle-nav-item.active::after {
            content: '';
            position: absolute;
            top: 4px;
            width: 6px;
            height: 6px;
            background: #ff6b00;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(255, 107, 0, 0.6);
        }

        /* Hover */
        .dubizzle-nav-item:hover .icon {
            background: #fff2e6;
            transform: scale(1.05);
        }

        /* Prevent content overlap */
        body {
            padding-bottom: 100px !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <!-- DUBIZZLE OFFICIAL MOBILE BOTTOM NAVBAR - 100% MATCH -->
    <div id="mobileNav" class="d-block d-md-none position-fixed bottom-0 start-0 end-0" style="z-index: 9999; pointer-events: none;">
        <div class="dubizzle-nav-wrapper" style="pointer-events: auto;">
            <div class="dubizzle-mobile-nav bg-white"
                style="display: flex; height: 72px; border-top: 1px solid #e4e4e4; 
                    box-shadow: 0 -2px 12px rgba(0,0,0,0.08);
                    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">

                <!-- <a href="#summary"     class="dubizzle-nav-item active" data-section="summary">
                <div class="icon"><i class="fas fa-home"></i></div>
                <span>Summary</span>
            </a> -->
                <a href="#car-details" class="dubizzle-nav-item" data-section="car-details">
                    <div class="icon"><i class="fas fa-car"></i></div>
                    <span>Car Details</span>
                </a>
                <a href="#exterior" class="dubizzle-nav-item" data-section="exterior">
                    <div class="icon"><i class="fas fa-paint-roller"></i></div>
                    <span>Exterior</span>
                </a>
                <a href="#specs" class="dubizzle-nav-item" data-section="specs">
                    <div class="icon"><i class="fas fa-cogs"></i></div>
                    <span>Specs</span>
                </a>
                <!-- <a href="#wheels"      class="dubizzle-nav-item" data-section="wheels">
                <div class="icon"><i class="fas fa-tire"></i></div>
                <span>Wheels & Tyres</span>
            </a> -->
                <!-- <a href="#engine"      class="dubizzle-nav-item" data-section="engine">
                <div class="icon"><i class="fas fa-engine"></i></div>
                <span>Engine</span>
            </a> -->
                <!-- <a href="#steering"    class="dubizzle-nav-item" data-section="steering">
                <div class="icon"><i class="fas fa-steering-wheel"></i></div>
                <span>Steering & Brakes</span>
            </a> -->

                <a href="#interior" class="dubizzle-nav-item" data-section="interior">
                    <div class="icon"><i class="fas fa-chair"></i></div>
                    <span>Interior</span>
                </a>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="">
            <!-- ==================================================================== -->
            <!-- == START: REFACTORED HEADER (Use this for both web and PDF) == -->
            <!-- ==================================================================== -->
            <table class="header-table" width="100%">
                <tr>
                    <td class="header-logo-cell" valign="bottom">
                        <img src="{{ asset('images/caartl.png') }}" alt="Golden X Logo" class="header-logo-img">
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
            {{-- Premium Image Gallery Section --}}
            <div class="report-card-top" id="summary">
                <div class="card-header-top p-3">
                    <h3><b>{{ $reportInView->year ?? 'N/A' }} - {{ $reportInView->brand?->name ?? 'N/A' }} {{ $reportInView->vehicleModel?->name ?? 'N/A' }}</b></h3>
                    <!-- <i class="fa-solid fa-images"></i> Vehicle Images -->
                </div>

                @php
                $vehicleImages = $reportInView->images ?? collect();
                if (!($vehicleImages instanceof \Illuminate\Support\Collection)) {
                $vehicleImages = collect($vehicleImages ?: []);
                }
                @endphp

                <div class="card-body-top ">
                    <div class="container">
                        @if($vehicleImages->count())
                        <div class="row g-3">
                            {{-- Main Large Image --}}
                            <div class="col-12 col-md-8">
                                @php $firstImage = $vehicleImages->first(); @endphp
                                @if($firstImage)
                                <img onclick="openImagesModal()"
                                    src="{{ asset('storage/' . $firstImage->path) }}"
                                    alt="Vehicle Image"
                                    class="img-fluid rounded shadow w-100"
                                    style="max-height: 600px;  cursor: pointer;">
                                @endif
                            </div>

                            {{-- Side Images --}}
                            <div class="col-12 col-md-4 d-flex flex-column gap-3">
                                @foreach($vehicleImages->skip(1)->take(1) as $image)
                                <img onclick="openImagesModal()"
                                    src="{{ asset('storage/' . $image->path) }}"
                                    alt="Vehicle Image"
                                    class="img-fluid rounded shadow w-100"
                                    style="height: 190px; object-fit: cover; cursor: pointer;">
                                @endforeach

                                {{-- Extra images counter overlay on last thumbnail --}}
                                @if($vehicleImages->count() > 3)
                                <div class="position-relative" onclick="openImagesModal()" style="cursor: pointer;">
                                    <img src="{{ asset('storage/' . $vehicleImages->skip(2)->first()->path) }}"
                                        alt="Vehicle Image"
                                        class="img-fluid rounded shadow w-100"
                                        style="height: 190px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 d-flex align-items-center justify-content-center p-2 bg-dark bg-opacity-50 text-white fw-bold fs-5 rounded"
                                        style="pointer-events: none;">
                                        <i class="fa-solid fa-images mx-3"></i>
                                        {{ $vehicleImages->count() - 3 }} more
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="no-images text-center py-4">
                            <i class="fas fa-image fa-2x text-muted mb-2"></i>
                            <h5>No Images Available</h5>
                            <p class="text-muted small">
                                No vehicle images have been uploaded for this inspection report.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Basic Vehicle Information Card - Show ALL fields --}}
            <div class="report-card" id="car-details">
                <div class="card-header p-3"><i class="fa-solid fa-car"></i>Basic Vehicle Information</div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row p-md-4">
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['make'] ?? 'fas fa-circle-notch' }}"></i> Make </div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->brand?->name ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['model'] ?? 'fas fa-circle-notch' }}"></i> Model</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->vehicleModel?->name ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['trim'] ?? 'fas fa-circle-notch' }}"></i> Trim</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->trim ?? 'N/A' }}</div>
                                </div>

                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['year'] ?? 'fas fa-circle-notch' }}"></i> Year</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->year ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['vin'] ?? 'fas fa-circle-notch' }}"></i> VIN</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->vin ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['odometer'] ?? 'fas fa-circle-notch' }}"></i> Mileage / Odometer</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->odometer.' kms' ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['engine_cc'] ?? 'fas fa-circle-notch' }}"></i> Engine CC</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->engine_cc ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['horsepower'] ?? 'fas fa-circle-notch' }}"></i> Horsepower</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->horsepower ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['color'] ?? 'fas fa-circle-notch' }}"></i> Color</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->color ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['specs'] ?? 'fas fa-circle-notch' }}"></i> Specs</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->specs ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row p-md-4">
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['registeredEmirates'] ?? 'fas fa-circle-notch' }}"></i> Registered Emirates</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->registerEmirates ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['body_type'] ?? 'fas fa-circle-notch' }}"></i> Body Type</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->body_type ?? 'N/A' }}</div>
                                </div>

                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['transmission'] ?? 'fas fa-circle-notch' }}"></i> Transmission</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->transmission ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['warrantyAvailable'] ?? 'fas fa-circle-notch' }}"></i> Warranty Available</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->warrantyAvailable ?? 'N/A' }}</div>
                                </div>

                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['serviceContractAvailable'] ?? 'fas fa-circle-notch' }}"></i> Service Contract</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->serviceContractAvailable ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['serviceHistory'] ?? 'fas fa-circle-notch' }}"></i> Service History</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->serviceHistory ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['noOfKeys'] ?? 'fas fa-circle-notch' }}"></i> No Of Keys</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->noOfKeys ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['mortgage'] ?? 'fas fa-circle-notch' }}"></i> Mortgage</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->mortgage ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 main-col-class col-bg-class">
                                    <div class="item-label"><i class="{{ $fieldIcons['noOfCylinders'] ?? 'fas fa-circle-notch' }}"></i> No. of Cylinders</div>
                                </div>
                                <div class="col-6 main-col-class">
                                    <div class="item-value">{{ $reportInView->noOfCylinders ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="report-card" id="exterior">
                <div class="card-header p-3"><i class="fa-solid fa-brush"></i>Exterior</div>
                <div class="card-body p-3">
                    <table class="">
                        {{-- Special full-width row for Paint Condition --}}
                        <tr>
                            <td colspan="{{ $columnsPerRow }}">
                                @php $field = 'paintCondition'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                @if(is_array($data)) <div class="item-value" style="text-align: left !important;">
                                    <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                </div>
                                @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                @else <div class="item-value" style="text-align: left !important;">{{ $data }}</div> @endif
                            </td>
                        </tr>
                        {{-- Row 1 of other fields --}}
                        <tr>

                        </tr>
                        {{-- Row 2 of other fields --}}

                    </table>
                </div>
            </div>


            {{-- Damage Assessment Section --}}
            <div class="report-card">
                @if($reportInView->damage_file_path && file_exists(public_path(parse_url($reportInView->damage_file_path, PHP_URL_PATH))))
                @php
                $imageData = base64_encode(file_get_contents(public_path(parse_url($reportInView->damage_file_path, PHP_URL_PATH))));
                $mimeType = mime_content_type(public_path(parse_url($reportInView->damage_file_path, PHP_URL_PATH)));
                @endphp
                <img src="data:{{ $mimeType }};base64,{{ $imageData }}" style="max-width: 100%; height: auto;">
                @else
                <div class="damage-assessment">
                    <div class="status-pill status-good">
                        <i class="fas fa-check-circle"></i>
                        No Damage Reported or Image Not Found
                    </div>
                </div>
                @endif

            </div>
            {{-- damage summery--}}
            <div class="report-card">
                <div class="card-header p-3">
                    <i class="fa-solid fa-car-burst"></i> Damage Assessment Report
                </div>
                <div class="card-body p-3">
                    @if($reportInView->damages->count())
                    <table class="details-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background:#c9da29; color: #fff;">
                                <th style="padding: 8px; text-align: left;">#</th>
                                <th style="padding: 8px; text-align: left;">Type</th>
                                <th style="padding: 8px; text-align: left;">Body Part</th>
                                <th style="padding: 8px; text-align: left;">Severity</th>
                                <th style="padding: 8px; text-align: left;">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportInView->damages as $index => $damage)
                            @php

                            $typeInfo = $damageTypes[$damage->type] ?? ['name' => 'Unknown', 'color' => '#999'];
                            $badgeColor = match(strtolower($damage->severity)) {
                            'minor' => '#28a745',
                            'moderate' => '#ffc107',
                            'major', 'severe' => '#dc3545',
                            default => '#17a2b8'
                            };
                            @endphp
                            <tr style="border-bottom: 1px solid #ccc;">
                                <td style="padding: 8px;">{{ $index + 1 }}</td>
                                <td style="padding: 8px;">
                                    <span style="
                                    display:inline-block;
                                    width:14px; height:14px;
                                    background:{{ $typeInfo['color'] }};
                                    border-radius:50%;
                                    margin-right:5px;
                                "></span>
                                    <strong>{{ strtoupper($damage->type) }}</strong>

                                </td>
                                <td style="padding: 8px;">{{ $damage->body_part }}</td>
                                <td style="padding: 8px;">
                                    <span style="
                                    background: {{ $badgeColor }};
                                    color: white;
                                    border-radius: 10px;
                                    padding: 4px 8px;
                                    font-size: 12px;
                                ">
                                        {{ ucfirst($damage->severity) }}
                                    </span>
                                </td>
                                <td style="padding: 8px;">{{ $damage->remark ?: 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="damage-assessment">
                        <div class="status-pill status-good">
                            <i class="fas fa-check-circle"></i>
                            No Damages Recorded
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="accordion" id="reportAccordion">
                {{-- ==================================================================== --}}
                {{-- == 3. Engine & Transmission Section (Accordion Item)                   --}}
                {{-- ==================================================================== --}}
                <div class="accordion-item report-card">
                    <h2 class="accordion-header" id="headingEngine">
                        <button class="accordion-button card-header p-3" type="button" data-bs-toggle="collapse" data-bs-target="#engineCollapse" aria-expanded="true" aria-controls="engineCollapse">
                            <i class="fa-solid fa-gears"></i>Engine & Transmission
                        </button>
                    </h2>
                    <div id="engineCollapse" class="accordion-collapse collapse show" aria-labelledby="headingEngine" data-bs-parent="#reportAccordion">
                        <div class="accordion-body card-body p-3">
                            <div class="row p-md-4">
                                <div class="col-md-6">
                                    {{-- Row 1 --}}
                                    <div class="row">
                                        @foreach(['engineOil', 'gearOil', 'gearshifting', 'engineNoise', 'engineSmoke'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    {{-- Row 2 --}}
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['fourWdSystemCondition', 'obdError'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach

                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @php $field = 'remarks'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================================================================== --}}
                {{-- == 4. Tires Section (Accordion Item)                                 --}}
                {{-- ==================================================================== --}}
                <div class="accordion-item report-card">
                    <h2 class="accordion-header" id="headingTires">
                        <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tiresCollapse" aria-expanded="false" aria-controls="tiresCollapse">
                            <i class="fa-solid fa-circle-dot"></i>Tires
                        </button>
                    </h2>
                    <div id="tiresCollapse" class="accordion-collapse collapse" aria-labelledby="headingTires" data-bs-parent="#reportAccordion">
                        <div class="accordion-body card-body p-3">
                            <div class="row p-md-3">
                                {{-- Row 1 --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['frontLeftTire', 'frontRightTire', 'rearLeftTire', 'rearRightTire', 'tiresSize'] as $field)
                                        <div class="col-6">
                                            <div class="item-label field-clickable" data-field="{{ $field }}" style="cursor:pointer;">
                                                <i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i>
                                                {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}
                                            </div>
                                            @php
                                            $data = $reportInView->{$field} ?? 'N/A';
                                            $statusInfo = getStatusInfo($data);
                                            @endphp
                                        </div>
                                        <div class="col-6">
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
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Row 2 --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['spareTire','wheelsType', 'rimsSizeFront','rimsSizeRear'] as $field)
                                        <div class="col-6">
                                            <div class="item-label field-clickable" data-field="{{ $field }}" style="cursor:pointer;">
                                                <i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i>
                                                {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}
                                            </div>
                                            @php
                                            $data = $reportInView->{$field} ?? 'N/A';
                                            $statusInfo = getStatusInfo($data);
                                            @endphp
                                        </div>
                                        <div class="col-6">
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
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Full-width row for Tire Comments --}}
                                <div class="col-12">
                                    @php
                                    $field = 'commentTire';
                                    $data = $reportInView->{$field} ?? 'N/A';
                                    $statusInfo = getStatusInfo($data);
                                    @endphp
                                    <div class="item-label field-clickable" data-field="{{ $field }}" style="cursor:pointer;">
                                        <i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> Comments
                                    </div>
                                    @if(is_array($data))
                                    <div class="item-value">
                                        <ul class="item-value-list">
                                            @foreach($data as $value)
                                            <li>{{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @elseif($statusInfo['class'] !== 'item-value')
                                    <div class="status-pill {{ $statusInfo['class'] }}" style="text-align: left !important;">
                                        <i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}
                                    </div>
                                    @else
                                    <div class="item-value">{{ $data }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>





                {{-- ==================================================================== --}}
                {{-- == 5. Car Specs Section (Accordion Item)                             --}}
                {{-- ==================================================================== --}}
                <div class="accordion-item report-card" id="specs">
                    <h2 class="accordion-header" id="headingSpecs">
                        <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#specsCollapse" aria-expanded="false" aria-controls="specsCollapse">
                            <i class="fa-solid fa-sliders"></i>Car Specs
                        </button>
                    </h2>
                    <div id="specsCollapse" class="accordion-collapse collapse" aria-labelledby="headingSpecs" data-bs-parent="#reportAccordion">
                        <div class="accordion-body card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['parkingSensors', 'keylessStart', 'seats', 'cooledSeats', 'heatedSeats'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['powerSeats', 'viveCamera', 'sunroofType', 'drive','blindSpot'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['headsDisplay','premiumSound','carbonFiber','convertible','sideSteps'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['soft_door_closing'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-door-closed' }} "></i> Soft Door Closing</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ==================================================================== --}}
                {{-- == 6. Interior, Electrical & Air Conditioner Section (Accordion Item) --}}
                {{-- ==================================================================== --}}
                <div class="accordion-item report-card" id="interior">
                    <h2 class="accordion-header" id="headingInterior">
                        <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#interiorCollapse" aria-expanded="false" aria-controls="interiorCollapse">
                            <i class="fa-solid fa-bolt"></i>Interior, Electrical & Air Conditioner
                        </button>
                    </h2>
                    <div id="interiorCollapse" class="accordion-collapse collapse" aria-labelledby="headingInterior" data-bs-parent="#reportAccordion">
                        <div class="accordion-body card-body p-3">
                            <div class="row">
                                {{-- Row 1 --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['speedmeterCluster', 'headLining', 'seatControls', 'seatsCondition', 'centralLockOperation'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Row 2 --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['sunroofCondition', 'windowsControl', 'cruiseControl', 'acCooling'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                                {{-- Full-width row for Comments --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            @php $field = 'comment_section2'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> Comments</div>
                                        </div>
                                        <div class="col-12">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ==================================================================== --}}
                {{-- == 7. Steering, Suspension & Brakes Section (Accordion Item)         --}}
                {{-- ==================================================================== --}}
                <div class="accordion-item report-card">
                    <h2 class="accordion-header" id="headingSteering">
                        <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#steeringCollapse" aria-expanded="false" aria-controls="steeringCollapse">
                            <i class="fa-solid fa-car-burst"></i>Steering, Suspension & Brakes
                        </button>
                    </h2>
                    <div id="steeringCollapse" class="accordion-collapse collapse" aria-labelledby="headingSteering" data-bs-parent="#reportAccordion">
                        <div class="accordion-body card-body p-3">
                            <div class="row">
                                {{-- Row 1 --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['steeringOperation', 'wheelAlignment', 'brakePads', 'suspension', 'brakeDiscs'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Row 2 --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        @foreach(['shockAbsorberOperation'] as $field)
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> {{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</div>
                                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        </div>
                                        <div class="col-6 field-clickable" data-field="{{ $field }}">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Full-width row for Comments --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            @php $field = 'comment_section1'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                            <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-circle-notch' }}"></i> Comments</div>
                                        </div>
                                        <div class="col-12">
                                            @if(is_array($data)) <div class="item-value">
                                                <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                            </div>
                                            @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                            @else <div class="item-value">{{ $data }}</div> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ==================================================================== --}}
                {{-- == 8. Final Conclusion Section (Accordion Item)                        --}}
                {{-- ==================================================================== --}}
                <div class="accordion-item report-card">
                    <h2 class="accordion-header" id="headingFinal">
                        {{-- Note the 'collapsed' class to ensure it's closed by default --}}
                        <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalCollapse" aria-expanded="false" aria-controls="finalCollapse">
                            <i class="fa-solid fa-clipboard"></i>Final Conclusion
                        </button>
                    </h2>
                    <div id="finalCollapse" class="accordion-collapse collapse" aria-labelledby="headingFinal" data-bs-parent="#reportAccordion">
                        <div class="accordion-body card-body p-3">
                            {{-- NOTE: We replaced the <table class="details-table"> structure with a standard <div> for cleaner Accordion content --}}
                            <div class="row">
                                <div class="col-12">
                                    @php $field = 'final_conclusion'; $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                    <div class="item-label"><i class="{{ $fieldIcons[$field] ?? 'fas fa-flag' }} "></i> Final Conclusion</div>
                                    @if(is_array($data)) <div class="item-value">
                                        <ul class="item-value-list">@foreach($data as $value)<li>{{ $value }}</li>@endforeach</ul>
                                    </div>
                                    @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                    @else <div class="item-value">{{ $data }}</div> @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- disclaimer -->
            {{--
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
                                Caartl encourages you to contact a different service provider who undertakes that type
                                of inspection. 3. Caartl does not inspect historic service records or accident records for
                                the vehicle, and does not check whether the vehicle is subject to a recall notice. 4. While
                                Caartl uses accepted methods for inspecting the vehicle, these methods do not
                                necessarily identify all faults with the vehicle. In particular, the inspection does not cover
                                intermittent problems which are not apparent at the time of the inspection. 5. This
                                Inspection Report, and all intellectual property rights therein, will remain the exclusive
                                property of Caartl. 6. This Inspection Report represents Caartl subjective opinion as to
                                the condition of the vehicle (limited to the specific items listed in this Inspection Report),
                                considering the age and condition of the vehicle at the time of inspection and based on the
                                Caartlinspector's knowledge and experience. This Inspection Report is designed to assist
                                you to make decisions based on the general condition of the vehicle only. Caartl will not
                                provide a recommendation as to whether to sell or purchase the vehicle. 7. Caartl can
                                only advise on the condition of the vehicle at the time of the inspection, and this Inspection
                                Report is only current as at the time it is issued. If you are considering purchasing the
                                vehicle, it is your responsibility to conduct a further inspection of the vehicle at the time of
                                purchase. 8. This Inspection Report is provided by Caartl 'as is' for your information only,
                                without any warranties whatsoever. In particular, Caartl does not provide any warranty
                                regarding the accuracy or completeness of any information contained in this Inspection
                                Report, or the fitness of the information contained in this Inspection Report for any purpose
                                intended. 9. If this Inspection Report is provided to you directly by Caartl, only you may
                                rely on the content of this Inspection Report, and Caartl does not accept any liability
                                whatsoever to any third-party you may choose to share this Inspection Report with. 10. If
                                this Inspection Report is provided to you by someone else than Caartl, you may not rely
                                on the content of this Inspection Report, and Caartl does not accept any liability
                                whatsoever to you in connection with this Inspection Report.
                            </p>
                        </div>
                    </td>


                </tr>
            </table>
        </div>
    </div> --}}

            <div class="footer">
                <span class="footer-brand">Caartl</span> &copy; {{ date('Y') }} | Vehicle Inspection Report
            </div>
        </div>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap 5 Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Fullscreen Modal with Carousel --}}
        <div class="modal fade" id="imageSliderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body ">

                        {{-- Main Carousel --}}
                        <div id="vehicleImagesCarousel" class="carousel slide w-100 mb-4" data-bs-ride="false">
                            <div class="carousel-inner text-center">
                                @foreach($vehicleImages as $i => $image)
                                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                        class="d-block mx-auto img-fluid"
                                        style="max-height: 75vh; object-fit: contain; padding:20px; border-radius:12px;">
                                </div>
                                @endforeach
                            </div>

                            {{-- Navigation arrows --}}
                            <button class="carousel-control-prev" type="button" data-bs-target="#vehicleImagesCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#vehicleImagesCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                        <div class="" style="overflow: auto;display:flex;">
                            @foreach($vehicleImages as $i => $image)
                            <img src="{{ asset('storage/' . $image->path) }}"
                                onclick="jumpToImage({{ $i }})"
                                class="img-thumbnail"
                                style="width:100px; height:70px; object-fit:cover; cursor:pointer; border:2px solid #444; border-radius:6px;">
                            @endforeach
                        </div>


                    </div>

                </div>
            </div>
        </div>
        {{-- ==================================================================== --}}
        {{-- == Modal for Field Images                                           --}}
        {{-- ==================================================================== --}}
        <!-- Shared Image Modal -->
<div class="modal fade" id="fieldImagesModal" tabindex="-1"
     aria-labelledby="fieldImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fieldImagesModalLabel">Field Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body text-center p-2">
                <!-- Carousel (mobile OR >3 items) -->
                <div id="fieldImagesCarousel" class="carousel slide"
                     data-bs-ride="false" style="display:none;">
                    <div class="carousel-inner" id="carouselInner"></div>

                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#fieldImagesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                            data-bs-target="#fieldImagesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- Static row (≤3 items on desktop) -->
                <div id="staticImagesRow"
                     class="d-flex justify-content-center flex-wrap gap-3"
                     style="display:none;"></div>

                <p id="noImagesText" class="text-muted mt-3" style="display:none;">
                    No media found for this field.
                </p>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal         = new bootstrap.Modal('#fieldImagesModal');
    const carouselInner = document.getElementById('carouselInner');
    const carousel      = document.getElementById('fieldImagesCarousel');
    const staticRow     = document.getElementById('staticImagesRow');
    const noMediaText   = document.getElementById('noImagesText'); // ← FIXED
    const modalTitle    = document.getElementById('fieldImagesModalLabel');

    /* --------------------------------------------------------------
       Render a single media item
       -------------------------------------------------------------- */
    function renderMedia(item, isCarousel = false) {
        const {path, thumb, file_type} = item;
        const isMobile = window.innerWidth <= 768;

        if (file_type === 'image') {
            const maxH = isCarousel ? (isMobile ? '250px' : '420px') : '250px';
            return `<img src="${path}" loading="lazy"
                         class="rounded ${isCarousel ? 'd-block mx-auto' : 'img-fluid'}"
                         style="max-height:${maxH}; width:auto; object-fit:contain;"
                         alt="Field image">`;
        }

        const videoH   = isMobile ? '220px' : '380px';
        const ctrlPad  = isMobile ? '80px' : '90px';
        const poster   = thumb ? `poster="${thumb}"` : '';

        return `
            <div style="position:relative; padding-bottom:${ctrlPad}; text-align:center;">
                <video controls ${poster} preload="metadata" playsinline
                       class="rounded shadow-sm"
                       style="max-height:${videoH}; max-width:100%; object-fit:contain; display:block; margin:0 auto;"
                       onclick="this.play();">
                    <source src="${path}" type="video/mp4">
                    Your browser does not support video.
                </video>
            </div>`;
    }

    /* --------------------------------------------------------------
       Click handler
       -------------------------------------------------------------- */
    document.querySelectorAll('.field-clickable').forEach(el => {
        el.addEventListener('click', async () => {
            const fieldName = el.getAttribute('data-field');
            const reportId  = "{{ $reportInView->id }}";

            modalTitle.textContent = `${fieldName} Media`;
            carouselInner.innerHTML = '';
            staticRow.innerHTML     = '';
            noMediaText.style.display = 'none';
            carousel.style.display    = 'none';
            staticRow.style.display   = 'none';

            try {
                const resp = await fetch(`/api/inspection-field-images/${reportId}/${fieldName}`);
                const {images: files} = await resp.json();

                if (!files || files.length === 0) {
                    noMediaText.style.display = 'block';
                    modal.show();
                    return;
                }

                const isMobile    = window.innerWidth <= 768;
                const useCarousel = isMobile || files.length > 3;

                if (useCarousel) {
                    carousel.style.display = 'block';
                    carouselInner.style.padding = isMobile ? '0' : '';
                    files.forEach((item, idx) => {
                        const active = idx === 0 ? 'active' : '';
                        carouselInner.insertAdjacentHTML(
                            'beforeend',
                            `<div class="carousel-item ${active} p-0">${renderMedia(item, true)}</div>`
                        );
                    });
                } else {
                    staticRow.style.display = 'flex';
                    files.forEach(item => {
                        staticRow.insertAdjacentHTML(
                            'beforeend',
                            `<div class="p-1">${renderMedia(item, false)}</div>`
                        );
                    });
                }

                modal.show();
            } catch (err) {
                console.error(err);
                noMediaText.textContent = 'Error loading media.';
                noMediaText.style.display = 'block';
                modal.show();
            }
        });
    });

    /* --------------------------------------------------------------
       Resize – keep video height consistent
       -------------------------------------------------------------- */
    window.addEventListener('resize', () => {
        const isMobile = window.innerWidth <= 768;
        const h = isMobile ? '220px' : '380px';
        document.querySelectorAll('#carouselInner video').forEach(v => {
            v.style.maxHeight = h;
        });
    });

    /* --------------------------------------------------------------
       STOP ALL VIDEOS WHEN MODAL IS CLOSED
       -------------------------------------------------------------- */
    document.getElementById('fieldImagesModal').addEventListener('hidden.bs.modal', function () {
        document.querySelectorAll('video').forEach(video => {
            video.pause();
            video.currentTime = 0;
        });
    });
});
</script>

        <script>
            function openImagesModal(startIndex = 0) {
                var myModal = new bootstrap.Modal(document.getElementById('imageSliderModal'));
                myModal.show();

                var carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('vehicleImagesCarousel'));
                carousel.to(startIndex);
            }

            function jumpToImage(index) {
                var carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('vehicleImagesCarousel'));
                carousel.to(index);
            }
        </script>
        <script>
            document.querySelectorAll('.details-table td').forEach((td, i) => {
                const headers = ['#', 'Type', 'Body Part', 'Severity', 'Remarks'];
                td.setAttribute('data-label', headers[i % 5]);
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const sections = {
                    summary: document.querySelector("#summary"),
                    "car-details": document.querySelector("#car-details"),
                    exterior: document.querySelector("#exterior"),
                    wheels: document.querySelector("#tiresCollapse"),
                    engine: document.querySelector("#engineCollapse"),
                    steering: document.querySelector("#steeringCollapse"),
                    interior: document.querySelector("#interior"),
                    specs: document.querySelector("#specs")
                };

                const navItems = document.querySelectorAll(".dubizzle-nav-item");

                function updateActive() {
                    let current = "summary";
                    const scrollPos = window.scrollY + 180;

                    Object.keys(sections).forEach(key => {
                        const el = sections[key];
                        if (el && scrollPos >= el.offsetTop - 100 && scrollPos < el.offsetTop + el.offsetHeight) {
                            current = key;
                        }
                    });

                    navItems.forEach(item => {
                        item.classList.toggle("active", item.getAttribute("data-section") === current);
                    });
                }

                window.addEventListener("scroll", updateActive);
                updateActive();
            });
        </script>
    </div>
</body>

</html>