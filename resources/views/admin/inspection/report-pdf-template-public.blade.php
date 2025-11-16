<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inspection Report #{{ $reportInView->id }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Google Fonts & Font Awesome --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/inspection.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .row>[class*="col-"] {
            padding: 6px 10px;
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

        .item-label .media-badge {
            background: var(--primary-color);
            color: #000;
            font-weight: 700;
            font-size: 0.65em;
            padding: 0.15em 0.45em;
            border-radius: 12px;
            min-width: 18px;
            text-align: center;
        }

        .item-value {
            font-size: 14px;
            font-weight: 500;
            text-align: right;
            color: var(--text-dark);
        }

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

        .card-body-top .row {
            margin: 0 -10px;
        }

        .card-body-top img {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

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

        @media (max-width: 768px) {
            .header-details-cell h1 {
                font-size: 18px;
            }

            .header-logo-img {
                max-width: 130px;
            }

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

            .accordion-button {
                padding: 16px 18px !important;
                font-size: 16px;
            }

            .status-pill {
                float: none;
                display: block;
                text-align: center;
                margin-top: 8px;
            }

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

        .dex-mobile-nav {
            border-radius: 24px 24px 0 0;
            overflow: hidden;
            padding: 8px 4px 12px;
            background: rgba(255, 255, 255, 0.95) !important;
        }

        .dex-nav-item {
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

        .dex-nav-item .icon {
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

        .dex-nav-item i {
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .dex-nav-item.active {
            color: #ff6b00 !important;
        }

        .dex-nav-item.active .icon {
            background: #fff2e6;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.25);
            transform: scale(1.1);
        }

        .dex-nav-item.active i {
            transform: translateY(-2px);
        }

        .dex-nav-item.active::after {
            content: '';
            position: absolute;
            top: 4px;
            width: 6px;
            height: 6px;
            background: #ff6b00;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(255, 107, 0, 0.6);
        }

        .dex-nav-item:hover .icon {
            background: #fff2e6;
            transform: scale(1.05);
        }

        body {
            padding-bottom: 100px !important;
        }

        html {
            scroll-behavior: smooth;
        }

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
</head>

<body>

    <!-- MOBILE NAVBAR -->
    <div id="mobileNav" class="d-block d-md-none position-fixed bottom-0 start-0 end-0" style="z-index: 9999; pointer-events: none;">
        <div class="dex-nav-wrapper" style="pointer-events: auto;">
            <div class="dex-mobile-nav bg-white" style="display: flex; height: 72px; border-top: 1px solid #e4e4e4; box-shadow: 0 -2px 12px rgba(0,0,0,0.08); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                <a href="#car-details" class="dex-nav-item" data-section="car-details">
                    <div class="icon"><i class="fas fa-car"></i></div>
                    <span>Car Details</span>
                </a>
                <a href="#exterior" class="dex-nav-item" data-section="exterior">
                    <div class="icon"><i class="fas fa-paint-roller"></i></div>
                    <span>Exterior</span>
                </a>
                <a href="#specs" class="dex-nav-item" data-section="specs">
                    <div class="icon"><i class="fas fa-cogs"></i></div>
                    <span>Specs</span>
                </a>
                <a href="#interior" class="dex-nav-item" data-section="interior">
                    <div class="icon"><i class="fas fa-chair"></i></div>
                    <span>Interior</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- HEADER -->
        <table class="header-table" width="100%">
            <tr>
                <td class="header-logo-cell" valign="bottom">
                    <img src="{{ asset('images/caartl.png') }}" alt="Logo" class="header-logo-img">
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

        @php
        use App\Models\InspectionField;

        /**
        * Return media count and hasMedia flag
        */
        function fieldHasMedia($reportId, $fieldName) {
        $count = InspectionField::where('vehicle_inspection_report_id', $reportId)
        ->where('name', $fieldName)
        ->withCount('files')
        ->first()
        ->files_count ?? 0;

        return [
        'has' => $count > 0,
        'count' => $count
        ];
        }

        /**
        * Render label with primary-colored count badge
        */
        function renderLabel($field, $icon, $hasMediaData) {
        $label = \Illuminate\Support\Str::of($field)
        ->kebab()
        ->replace('-', ' ')
        ->title();

        $html = '<div class="item-label">';
            $html .= '<i class="'.$icon.'"></i> '.$label;

            if ($hasMediaData['has']) {
            $count = $hasMediaData['count'];
            $html .= '<i class="fas fa-camera text--primary ms-2" title="'.$count.' media file(s)"></i>';
            }


            $html .= '</div>';
        return $html;
        }

        $fieldIcons = [
        'make' => 'fas fa-industry', 'model' => 'fas fa-car', 'trim' => 'fas fa-tag', 'year' => 'fas fa-calendar-alt',
        'vin' => 'fas fa-barcode', 'odometer' => 'fas fa-tachometer-alt', 'color' => 'fas fa-palette',
        'engine_cc' => 'fas fa-engine', 'horsepower' => 'fas fa-horse-head', 'specs' => 'fas fa-sliders-h',
        'registeredEmirates' => 'fas fa-map-marker-alt', 'body_type' => 'fas fa-car-side', 'transmission' => 'fas fa-cogs',
        'warrantyAvailable' => 'fas fa-shield-alt', 'serviceContractAvailable' => 'fas fa-handshake',
        'serviceHistory' => 'fas fa-history', 'noOfKeys' => 'fas fa-key', 'mortgage' => 'fas fa-file-invoice-dollar',
        'noOfCylinders' => 'fas fa-cog', 'paintCondition' => 'fas fa-spray-can', 'engineOil' => 'fas fa-oil-can',
        'gearOil' => 'fas fa-gear', 'gearshifting' => 'fas fa-gears', 'engineNoise' => 'fas fa-volume-high',
        'engineSmoke' => 'fas fa-smog', 'fourWdSystemCondition' => 'fas fa-car-side', 'obdError' => 'fas fa-triangle-exclamation',
        'remarks' => 'fas fa-comment-dots', 'frontLeftTire' => 'fas fa-circle-dot', 'frontRightTire' => 'fas fa-circle-dot',
        'rearLeftTire' => 'fas fa-circle-dot', 'rearRightTire' => 'fas fa-circle-dot', 'tiresSize' => 'fas fa-ruler-combined',
        'spareTire' => 'fas fa-life-ring', 'wheelsType' => 'fas fa-circle-dot', 'rimsSizeFront' => 'fas fa-arrows-left-right',
        'rimsSizeRear' => 'fas fa-arrows-left-right', 'commentTire' => 'fas fa-comment', 'parkingSensors' => 'fas fa-radar',
        'keylessStart' => 'fas fa-key', 'seats' => 'fas fa-chair', 'cooledSeats' => 'fas fa-snowflake',
        'heatedSeats' => 'fas fa-fire', 'powerSeats' => 'fas fa-bolt', 'viveCamera' => 'fas fa-camera-retro',
        'sunroofType' => 'fas fa-sun', 'drive' => 'fas fa-road', 'headsDisplay' => 'fas fa-desktop',
        'premiumSound' => 'fas fa-music', 'carbonFiber' => 'fas fa-cubes', 'convertible' => 'fas fa-car',
        'blindSpot' => 'fas fa-eye', 'sideSteps' => 'fas fa-shoe-prints', 'soft_door_closing' => 'fas fa-door-closed',
        'speedmeterCluster' => 'fas fa-gauge-high', 'headLining' => 'fas fa-arrow-up', 'seatControls' => 'fas fa-toggle-on',
        'seatsCondition' => 'fas fa-check-double', 'centralLockOperation' => 'fas fa-lock', 'sunroofCondition' => 'fas fa-sun',
        'windowsControl' => 'fas fa-window-maximize', 'cruiseControl' => 'fas fa-forward', 'acCooling' => 'fas fa-wind',
        'comment_section2' => 'fas fa-comments', 'steeringOperation' => 'fas fa-dharmachakra', 'wheelAlignment' => 'fas fa-arrows-to-dot',
        'brakePads' => 'fas fa-compact-disc', 'suspension' => 'fas fa-car-burst', 'brakeDiscs' => 'fas fa-compact-disc',
        'shockAbsorberOperation' => 'fas fa-car-burst', 'comment_section1' => 'fas fa-comments', 'final_conclusion' => 'fas fa-clipboard'
        ];
        @endphp

        <!-- IMAGE GALLERY -->
        <div class="report-card-top" id="summary">
            <div class="card-header-top p-3">
                <h3><b>{{ $reportInView->year ?? 'N/A' }} - {{ $reportInView->brand?->name ?? 'N/A' }} {{ $reportInView->vehicleModel?->name ?? 'N/A' }}</b></h3>
            </div>
            <div class="card-body-top">
                @php $vehicleImages = $reportInView->images ?? collect(); @endphp
                <div class="container">
                    @if($vehicleImages->count())
                    <div class="row g-3">
                        <div class="col-12 col-md-8">
                            @if($vehicleImages->first())
                            <img onclick="openImagesModal()" src="{{ asset('storage/' . $vehicleImages->first()->path) }}" class="img-fluid rounded shadow w-100" style="max-height:600px; cursor:pointer;">
                            @endif
                        </div>
                        <div class="col-12 col-md-4 d-flex flex-column gap-3">
                            @foreach($vehicleImages->skip(1)->take(1) as $image)
                            <img onclick="openImagesModal()" src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded shadow w-100" style="height:190px; object-fit:cover; cursor:pointer;">
                            @endforeach
                            @if($vehicleImages->count() > 3)
                            <div class="position-relative" onclick="openImagesModal()" style="cursor:pointer;">
                                <img src="{{ asset('storage/' . $vehicleImages->skip(2)->first()->path) }}" class="img-fluid rounded shadow w-100" style="height:190px; object-fit:cover;">
                                <div class="position-absolute bottom-0 d-flex align-items-center justify-content-center p-2 bg-dark bg-opacity-50 text-white fw-bold fs-5 rounded" style="pointer-events:none;">
                                    <i class="fa-solid fa-images mx-3"></i> {{ $vehicleImages->count() - 3 }} more
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="no-images text-center py-4">
                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                        <h5>No Images Available</h5>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- BASIC VEHICLE INFO -->
        <div class="report-card" id="car-details">
            <div class="card-header p-3"><i class="fa-solid fa-car"></i>Basic Vehicle Information</div>
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row p-md-4">
                            @foreach(['make','model','trim','year','vin','odometer','engine_cc','horsepower','color','specs'] as $field)
                            @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                            <div class="col-6 main-col-class col-bg-class">
                                {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                            </div>
                            <div class="col-6 main-col-class">
                                <div class="item-value">{{ $reportInView->{$field} ?? 'N/A' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row p-md-4">
                            @foreach(['registeredEmirates','body_type','transmission','warrantyAvailable','serviceContractAvailable','serviceHistory','noOfKeys','mortgage','noOfCylinders'] as $field)
                            @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                            <div class="col-6 main-col-class col-bg-class">
                                {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                            </div>
                            <div class="col-6 main-col-class">
                                <div class="item-value">{{ $reportInView->{$field} ?? 'N/A' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EXTERIOR -->
        <div class="report-card" id="exterior">
            <div class="card-header p-3"><i class="fa-solid fa-brush"></i>Exterior</div>
            <div class="card-body p-3">
                <table>
                    <tr>
                        <td colspan="5">
                            @php $field = 'paintCondition'; $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                            {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                            @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                            @if(is_array($data))
                            <div class="item-value" style="text-align:left !important;">
                                <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                            </div>
                            @elseif($statusInfo['class'] !== 'item-value')
                            <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                            @else
                            <div class="item-value" style="text-align:left !important;">{{ $data }}</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- DAMAGE ASSESSMENT IMAGE -->
        <div class="report-card">
            @if($reportInView->damage_file_path && file_exists(public_path(parse_url($reportInView->damage_file_path, PHP_URL_PATH))))
            @php
            $imageData = base64_encode(file_get_contents(public_path(parse_url($reportInView->damage_file_path, PHP_URL_PATH))));
            $mimeType = mime_content_type(public_path(parse_url($reportInView->damage_file_path, PHP_URL_PATH)));
            @endphp
            <img src="data:{{ $mimeType }};base64,{{ $imageData }}" style="max-width:100%; height:auto;">
            @else
            <div class="damage-assessment p-3 text-center">
                <div class="status-pill status-good"><i class="fas fa-check-circle"></i> No Damage Reported</div>
            </div>
            @endif
        </div>

        <!-- DAMAGE TABLE -->
        <div class="report-card">
            <div class="card-header p-3"><i class="fa-solid fa-car-burst"></i>Damage Assessment Report</div>
            <div class="card-body p-3">
                @if($reportInView->damages->count())
                <table class="details-table">
                    <thead>
                        <tr style="background:#c9da29; color:#fff;">
                            <th>#</th>
                            <th>Type</th>
                            <th>Body Part</th>
                            <th>Severity</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportInView->damages as $i => $d)
                        @php
                        $typeInfo = $damageTypes[$d->type] ?? ['name'=>'Unknown','color'=>'#999'];
                        $badge = match(strtolower($d->severity)) { 'minor'=>'#28a745','moderate'=>'#ffc107','major','severe'=>'#dc3545', default=>'#17a2b8' };
                        @endphp
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span style="display:inline-block;width:14px;height:14px;background:{{ $typeInfo['color'] }};border-radius:50%;margin-right:5px;"></span><strong>{{ strtoupper($d->type) }}</strong></td>
                            <td>{{ $d->body_part }}</td>
                            <td><span style="background:{{ $badge }};color:white;border-radius:10px;padding:4px 8px;font-size:12px;">{{ ucfirst($d->severity) }}</span></td>
                            <td>{{ $d->remark ?: 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="status-pill status-good"><i class="fas fa-check-circle"></i>No Damages Recorded</div>
                @endif
            </div>
        </div>

        <!-- ACCORDION SECTIONS -->
        <div class="accordion" id="reportAccordion">
            <!-- ENGINE & TRANSMISSION -->
            <div class="accordion-item report-card">
                <h2 class="accordion-header" id="headingEngine">
                    <button class="accordion-button card-header p-3" type="button" data-bs-toggle="collapse" data-bs-target="#engineCollapse" aria-expanded="true">
                        <i class="fa-solid fa-gears"></i>Engine & Transmission
                    </button>
                </h2>
                <div id="engineCollapse" class="accordion-collapse collapse show" data-bs-parent="#reportAccordion">
                    <div class="accordion-body card-body p-3">
                        <div class="row p-md-4">
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['engineOil','gearOil','gearshifting','engineNoise','engineSmoke'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['fourWdSystemCondition','obdError','remarks'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
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

            <!-- TIRES -->
            <div class="accordion-item report-card">
                <h2 class="accordion-header" id="headingTires">
                    <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tiresCollapse">
                        <i class="fa-solid fa-circle-dot"></i>Tires
                    </button>
                </h2>
                <div id="tiresCollapse" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                    <div class="accordion-body card-body p-3">
                        <div class="row p-md-3">
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['frontLeftTire','frontRightTire','rearLeftTire','rearRightTire','tiresSize'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6">
                                        <div class="item-label field-clickable" data-field="{{ $field }}" style="cursor:pointer;">
                                            {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['spareTire','wheelsType','rimsSizeFront','rimsSizeRear'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6">
                                        <div class="item-label field-clickable" data-field="{{ $field }}" style="cursor:pointer;">
                                            {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                @php $field = 'commentTire'; $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                <div class="item-label field-clickable" data-field="{{ $field }}" style="cursor:pointer;">
                                    {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                </div>
                                @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                @if(is_array($data)) <div class="item-value">
                                    <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                </div>
                                @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}" style="text-align:left !important;"><i class="{{ $statusInfo['icon'] }}"></i>{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div>
                                @else <div class="item-value">{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CAR SPECS -->
            <div class="accordion-item report-card" id="specs">
                <h2 class="accordion-header" id="headingSpecs">
                    <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#specsCollapse">
                        <i class="fa-solid fa-sliders"></i>Car Specs
                    </button>
                </h2>
                <div id="specsCollapse" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                    <div class="accordion-body card-body p-3">
                        <div class="row">
                            @foreach([['parkingSensors','keylessStart','seats','cooledSeats','heatedSeats'], ['powerSeats','viveCamera','sunroofType','drive','blindSpot'], ['headsDisplay','premiumSound','carbonFiber','convertible','sideSteps'], ['soft_door_closing']] as $group)
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach($group as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- INTERIOR, ELECTRICAL & AC -->
            <div class="accordion-item report-card" id="interior">
                <h2 class="accordion-header" id="headingInterior">
                    <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#interiorCollapse">
                        <i class="fa-solid fa-bolt"></i>Interior, Electrical & Air Conditioner
                    </button>
                </h2>
                <div id="interiorCollapse" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                    <div class="accordion-body card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['speedmeterCluster','headLining','seatControls','seatsCondition','centralLockOperation'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['sunroofCondition','windowsControl','cruiseControl','acCooling'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                @php $field = 'comment_section2'; $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                <div class="item-label">{!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}</div>
                                @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                @if(is_array($data)) <div class="item-value">
                                    <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                </div>
                                @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div>
                                @else <div class="item-value">{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEERING, SUSPENSION & BRAKES -->
            <div class="accordion-item report-card">
                <h2 class="accordion-header" id="headingSteering">
                    <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#steeringCollapse">
                        <i class="fa-solid fa-car-burst"></i>Steering, Suspension & Brakes
                    </button>
                </h2>
                <div id="steeringCollapse" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                    <div class="accordion-body card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['steeringOperation','wheelAlignment','brakePads','suspension','brakeDiscs'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach(['shockAbsorberOperation'] as $field)
                                    @php $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}
                                    </div>
                                    <div class="col-6 field-clickable" data-field="{{ $field }}">
                                        @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                        @if(is_array($data)) <div class="item-value">
                                            <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                        </div>
                                        @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{{ $data }}</div>
                                        @else <div class="item-value">{{ $data }}</div> @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                @php $field = 'comment_section1'; $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                <div class="item-label">{!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-circle-notch', $hasMedia) !!}</div>
                                @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                @if(is_array($data)) <div class="item-value">
                                    <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                </div>
                                @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div>
                                @else <div class="item-value">{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FINAL CONCLUSION -->
            <div class="accordion-item report-card">
                <h2 class="accordion-header" id="headingFinal">
                    <button class="accordion-button card-header p-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalCollapse">
                        <i class="fa-solid fa-clipboard"></i>Final Conclusion
                    </button>
                </h2>
                <div id="finalCollapse" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                    <div class="accordion-body card-body p-3">
                        <div class="row">
                            <div class="col-12">
                                @php $field = 'final_conclusion'; $hasMedia = fieldHasMedia($reportInView->id, $field); @endphp
                                {!! renderLabel($field, $fieldIcons[$field] ?? 'fas fa-flag', $hasMedia) !!}
                                @php $data = $reportInView->{$field} ?? 'N/A'; $statusInfo = getStatusInfo($data); @endphp
                                @if(is_array($data)) <div class="item-value">
                                    <ul class="item-value-list">@foreach($data as $v)<li>{{ $v }}</li>@endforeach</ul>
                                </div>
                                @elseif($statusInfo['class'] !== 'item-value') <div class="status-pill {{ $statusInfo['class'] }}"><i class="{{ $statusInfo['icon'] }}"></i>{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div>
                                @else <div class="item-value">{!! nl2br(e(preg_replace('/\. ?/', ".\n", $data))) !!}</div> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <span class="footer-brand">Caartl</span> &copy; {{ date('Y') }} | Vehicle Inspection Report
        </div>
    </div>

    <!-- MODALS & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- IMAGE MODAL -->
    <div class="modal fade" id="imageSliderModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="vehicleImagesCarousel" class="carousel slide w-100 mb-4" data-bs-ride="false">
                        <div class="carousel-inner text-center">
                            @foreach($vehicleImages as $i => $img)
                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img->path) }}" class="d-block mx-auto img-fluid" style="max-height:75vh; object-fit:contain; padding:20px; border-radius:12px;">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#vehicleImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#vehicleImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <div style="overflow:auto;display:flex;">
                        @foreach($vehicleImages as $i => $img)
                        <img src="{{ asset('storage/' . $img->path) }}" onclick="jumpToImage({{ $i }})" class="img-thumbnail" style="width:100px;height:70px;object-fit:cover;cursor:pointer;border:2px solid #444;border-radius:6px;">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FIELD IMAGES MODAL -->
    <div class="modal fade" id="fieldImagesModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fieldImagesModalLabel">Field Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <div id="fieldImagesCarousel" class="carousel slide" data-bs-ride="false" style="display:none;">
                        <div class="carousel-inner" id="carouselInner"></div>
                        <button,button class="carousel-control-prev" type="button" data-bs-target="#fieldImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#fieldImagesCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                    </div>
                    <div id="staticImagesRow" class="d-flex justify-content-center flex-wrap gap-3" style="display:none;"></div>
                    <p id="noImagesText" class="text-muted mt-3" style="display:none;">No media found for this field.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openImagesModal(startIndex = 0) {
            var modal = new bootstrap.Modal(document.getElementById('imageSliderModal'));
            modal.show();
            var carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('vehicleImagesCarousel'));
            carousel.to(startIndex);
        }

        function jumpToImage(index) {
            var carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('vehicleImagesCarousel'));
            carousel.to(index);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal('#fieldImagesModal');
            const carouselInner = document.getElementById('carouselInner');
            const carousel = document.getElementById('fieldImagesCarousel');
            const staticRow = document.getElementById('staticImagesRow');
            const noMediaText = document.getElementById('noImagesText');
            const modalTitle = document.getElementById('fieldImagesModalLabel');

            function renderMedia(item, isCarousel = false) {
                const {
                    path,
                    thumb,
                    file_type
                } = item;
                const isMobile = window.innerWidth <= 768;
                if (file_type === 'image') {
                    const maxH = isCarousel ? (isMobile ? '250px' : '420px') : '250px';
                    return `<img src="${path}" loading="lazy" class="rounded ${isCarousel ? 'd-block mx-auto' : 'img-fluid'}" style="max-height:${maxH};width:auto;object-fit:contain;" alt="Field image">`;
                }
                const videoH = isMobile ? '220px' : '380px';
                const ctrlPad = isMobile ? '80px' : '90px';
                const poster = thumb ? `poster="${thumb}"` : '';
                return `<div style="position:relative;padding-bottom:${ctrlPad};text-align:center;">
                    <video controls ${poster} preload="metadata" playsinline class="rounded shadow-sm" style="max-height:${videoH};max-width:100%;object-fit:contain;display:block;margin:0 auto;" onclick="this.play();">
                        <source src="${path}" type="video/mp4">
                        Your browser does not support video.
                    </video>
                </div>`;
            }

            document.querySelectorAll('.field-clickable').forEach(el => {
                el.addEventListener('click', async () => {
                    const fieldName = el.getAttribute('data-field');
                    const reportId = "{{ $reportInView->id }}";
                    modalTitle.textContent = `${fieldName} Media`;
                    carouselInner.innerHTML = '';
                    staticRow.innerHTML = '';
                    noMediaText.style.display = 'none';
                    carousel.style.display = 'none';
                    staticRow.style.display = 'none';

                    try {
                        const resp = await fetch(`/api/inspection-field-images/${reportId}/${fieldName}`);
                        const {
                            images: files
                        } = await resp.json();
                        if (!files || files.length === 0) {
                            noMediaText.style.display = 'block';
                            modal.show();
                            return;
                        }
                        const isMobile = window.innerWidth <= 768;
                        const useCarousel = isMobile || files.length > 3;
                        if (useCarousel) {
                            carousel.style.display = 'block';
                            files.forEach((item, idx) => {
                                const active = idx === 0 ? 'active' : '';
                                carouselInner.insertAdjacentHTML('beforeend', `<div class="carousel-item ${active} p-0">${renderMedia(item, true)}</div>`);
                            });
                        } else {
                            staticRow.style.display = 'flex';
                            files.forEach(item => {
                                staticRow.insertAdjacentHTML('beforeend', `<div class="p-1">${renderMedia(item, false)}</div>`);
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

            window.addEventListener('resize', () => {
                const isMobile = window.innerWidth <= 768;
                const h = isMobile ? '220px' : '380px';
                document.querySelectorAll('#carouselInner video').forEach(v => v.style.maxHeight = h);
            });

            document.getElementById('fieldImagesModal').addEventListener('hidden.bs.modal', () => {
                document.querySelectorAll('video').forEach(v => {
                    v.pause();
                    v.currentTime = 0;
                });
            });
        });

        document.querySelectorAll('.details-table td').forEach((td, i) => {
            const headers = ['#', 'Type', 'Body Part', 'Severity', 'Remarks'];
            td.setAttribute('data-label', headers[i % 5]);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const sections = {
                summary: document.querySelector("#summary"),
                "car-details": document.querySelector("#car-details"),
                exterior: document.querySelector("#exterior"),
                specs: document.querySelector("#specs")
            };
            const navItems = document.querySelectorAll(".dex-nav-item");

            function updateActive() {
                let current = "summary";
                const scrollPos = window.scrollY + 180;
                Object.keys(sections).forEach(key => {
                    const el = sections[key];
                    if (el && scrollPos >= el.offsetTop - 100 && scrollPos < el.offsetTop + el.offsetHeight) current = key;
                });
                navItems.forEach(item => item.classList.toggle("active", item.getAttribute("data-section") === current));
            }
            window.addEventListener("scroll", updateActive);
            updateActive();
        });
    </script>
</body>

</html>