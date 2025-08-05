<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Inspection Report #{{ $report->id }}</title>
    <style>
        /* General PDF-friendly styles */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .report-section {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            border-radius: 4px;
            page-break-inside: avoid;
            /* Important for preventing sections from splitting */
        }

        .section-title {
            background-color: #343a40;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
        }

        .section-body {
            padding: 10px;
        }

        /* --- KEY FIX: Table-based layout for reliability --- */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            /* Removes space between table cells */
        }

        .details-table td {
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }

        .item {
            margin-bottom: 5px;
        }

        .item-label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 2px;
        }

        .item-value {
            display: block;
            padding: 6px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 3px;
            min-height: 18px;
            /* --- KEY FIX: Force long text to wrap --- */
            word-wrap: break-word;
            white-space: normal;
        }

        .item-value-list {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }

        .item-value-list li {
            background-color: #e9ecef;
            color: #333;
            padding: 3px 8px;
            margin-bottom: 4px;
            margin-right: 4px;
            display: inline-block;
            border-radius: 10px;
            font-size: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #777;
            position: fixed;
            /* Optional: fixes footer to bottom of each page */
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Vehicle Inspection Report</h1>
            <p>Report ID: {{ $report->id }} | Date: {{ $report->created_at->format('F d, Y') }}</p>
        </div>

        {{-- Vehicle Details Section using a table --}}
        <div class="report-section">
            <div class="section-title">Vehicle Information</div>
            <div class="section-body">
                <table class="details-table">
                    <tr>
                        <td>
                            <div class="item"><span class="item-label">Make</span> <span class="item-value">{{ $report->make ?? 'N/A' }}</span></div>
                        </td>
                        <td>
                            <div class="item"><span class="item-label">Model</span> <span class="item-value">{{ $report->model ?? 'N/A' }}</span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item"><span class="item-label">Year</span> <span class="item-value">{{ $report->year ?? 'N/A' }}</span></div>
                        </td>
                        <td>
                            <div class="item"><span class="item-label">VIN</span> <span class="item-value">{{ $report->vin ?? 'N/A' }}</span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="item"><span class="item-label">Odometer</span> <span class="item-value">{{ $report->odometer ?? 'N/A' }}</span></div>
                        </td>
                        <td>
                            <div class="item"><span class="item-label">Color</span> <span class="item-value">{{ $report->color ?? 'N/A' }}</span></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Dynamic Sections Loop --}}
        @php
        // ... (The $sections array definition remains the same)
        $sections = [
        'Exterior' => ['paintCondition', 'convertible', 'blindSpot', 'sideSteps', 'wheelsType', 'rimsSizeFront', 'rimsSizeRear'],
        'Tires' => ['tiresSize', 'spareTire', 'frontLeftTire', 'frontRightTire', 'rearLeftTire', 'rearRightTire'],
        'Car Specs' => ['parkingSensors', 'keylessStart', 'seats', 'cooledSeats', 'heatedSeats', 'powerSeats', 'viveCamera', 'sunroofType', 'drive'],
        'Interior & Electrical' => ['speedmeterCluster', 'headLining', 'seatControls', 'seatsCondition', 'centralLockOperation', 'sunroofCondition', 'windowsControl', 'cruiseControl', 'acCooling'],
        'Engine & Transmission' => ['engineCondition', 'transmissionCondition', 'engineNoise', 'engineSmoke', 'fourWdSystemCondition', 'obdError', 'engineOil', 'gearOil'],
        'Steering, Suspension & Brakes' => ['steeringOperation', 'wheelAlignment', 'brakePads', 'suspension', 'brakeDiscs', 'shockAbsorberOperation'],
        ];
        @endphp

        @foreach($sections as $sectionName => $fields)
        @php
        $sectionData = [];
        foreach ($fields as $field) {
        if (true) {
        $sectionData[$field] = $report->{$field} ?? 'N/A';
        }
        }
        @endphp

        @if(!empty($sectionData))
        <div class="report-section">
            <div class="section-title">{{ $sectionName }}</div>
            <div class="section-body">
                <table class="details-table">
                    @foreach(array_chunk($sectionData, 2, true) as $chunk)
                    <tr>
                        @foreach($chunk as $field => $data)
                        <td>
                            <div class="item">
                                <span class="item-label">{{ Str::of($field)->kebab()->replace('-', ' ')->title() }}</span>
                                @if(is_array($data))
                                <div class="item-value">
                                    <ul class="item-value-list">
                                        @foreach($data as $value)
                                        <li>{{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @else
                                <span class="item-value">{{ $data }}</span>
                                @endif
                            </div>
                        </td>
                        @endforeach
                        {{-- Add an empty cell if there's only one item in the chunk --}}
                        @if(count($chunk) < 2)
                            <td>
                            </td>
                            @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif
        @endforeach

        <livewire:admin.inspection.car-damage-view :inspectionId="$report->id" />
    </div>
</body>

</html>