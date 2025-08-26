<div>
    <div class="container">
        <link rel="stylesheet" href="{{ asset('css/car-damage-assessment.css') }}">
        <div class="header">
            <!-- <h1>Exterior Condition Report</h1> -->
        </div>
        <div class="main-content-view-only">
            <div class="car-section">
                <div class="car-container">
                    <svg viewBox="0 0 2560 1440" class="car-svg" style="width: 100%; height: auto;">
                        <!-- Car Outline (SVG paths) -->
                        <style>
                            .s0 {
                                fill: none;
                                stroke: #000000;
                                stroke-miterlimit: 100;
                                stroke-width: 4.2
                            }

                            .damage-tooltip {
                                position: absolute;
                                background: #fff;
                                border: 1px solid #333;
                                padding: 8px;
                                z-index: 100;
                                min-width: 180px;
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                                border-radius: 4px;
                                display: none;
                                pointer-events: none;
                            }

                            .damage-point {
                                cursor: help;
                            }

                            .damage-point:hover+.damage-tooltip {
                                display: block;
                            }
                        </style>

                        <path id="Shape 1" class="s0"
                            d="m655.4 532.8c0 0-51.7 203-1.1 378l118.7-16.7c0 0-47.4-181.6-1-344.7z" />
                        <path id="Shape 2" class="s0"
                            d="m1416.3 545.1c0 0 52.7 239.5-1.1 350.8l204.5 52.6c0 0 129.7-119.4 47.7-377.1 0 0-10.6-34-47.7-68.4z" />
                        <path id="Shape 3" class="s0"
                            d="m440.3 503.8l165.3 30.7c0 0-58.2 206.5-8.5 375.4l8.5 13.2-165.3 32.4c0 0-114.4-218 0-451.7z" />
                        <path id="Shape 4" class="s0"
                            d="m233.6 546.8l-1 370.1c0 0-27.8 6.3-13.8 37.7l51.9 4.4 19.1 14c0 0 5.8 5.8 21.2 0l19 0.9v-21.9h20.2v-452.5l-20.2-2.7-2.1-14-31.8-1.8-23.3 13.2c0 0-99.3-8.7-39.2 52.6z" />
                        <path id="Shape 5" class="s0"
                            d="m1666.4 501.2c0 0-9.4-9.1 13.7-10.5l283 19.3c0 0 57 0 71 43.8 0 0 59.7 277.4-18 375.4 0 0-58.8 29.3-344.4 34.2l-10.6-11.4c0 0 174.7-181.4 5.3-450.8z" />
                        <path id="Shape 6" class="s0"
                            d="m833.4 545.1c0 0-62.8 88.2-12.7 342 0 0 393.3-11.8 546.8 6.1 0 0 54.9-208 4.3-346.4 0 0-327.3 28.9-538.4-1.7z" />
                        <path id="Shape 7" class="s0"
                            d="m2103 495.1l-2.2 467.4 54.1-4.4v19.3c0 0 43.1 4.7 84.8-14.9l27.5 0.9c0 0 11.3 1.7 12.7-24.6l1.1-433.2c0 0 1.2-16.6-22.3-14l-19 0.8c0 0-50.3-18.6-88-13.1l2.1 19.3z" />
                        <path id="Shape 8" class="s0"
                            d="m396.8 1152.8v-85c0 0 2.5-16.2 41.3-17.6l56.2 2.6c0 0 31.1-5.8 44.5-17.5 0 0 166.1-82.6 243.7-91.2 0 0 17.5-8.3 6.4 21.9 0 0-87.9 147.8-39.2 177.2 0 0-153.2-20.8-169.6 104.3 0 0 8.7 16.7-28.6 15.8-37.2-0.9-143-0.9-143-0.9 0 0-20.6 3.9-36.1-44.7 0 0-13.1-28 24.4-64.9z" />
                        <path id="Shape 9" class="s0"
                            d="m776.2 957.3l-127.2 78c0 0-24.1 11.8 3.2 24.6 0 0 44.9 7 77.4 1.7z" />
                        <path id="Shape 10" class="s0" d="m872.6 956.4l-37.1 103.5 272.4 4.3-12.7-113.1z" />
                        <path id="Shape 11" class="s0"
                            d="m404.2 1070.4c0 0 54.8-5.1 61.5 6.1 6.7 11.3 3.2 34.2 3.2 34.2 0 0 2.8 13.2-24.4 11.4-27.2-1.8-43.5 1.8-43.5 1.8 0 0-11.2-63.3 3.2-53.5z" />
                        <path id="Shape 12" class="s0"
                            d="m854.6 943.2c0 0 113.8-14.4 251.2 0 0 0 63.8 281.7 18 318.4l-200.3 1.7c0 0-35.3 5.4-41.3-36.8 0 0-13.9-36.9-74.2-78.1 0 0-35.2-24-3.2-86.8 32-62.8 49.8-118.4 49.8-118.4z" />
                        <path id="Shape 13" class="s0"
                            d="m1174.6 956.4l20.2 107.8 293.5 10.6v-14.1c0 0-155.4-111-313.7-104.3z" />
                        <path id="Shape 14" class="s0"
                            d="m1155.6 946.7c0 0 55.4 294.9 19 314l331.7 1.7c0 0 36.7-1.3 38.2-42.9v-122.8c0 0-50.6-72.1-217.3-128.9 0 0-63.9-30.9-171.6-21.1z" />
                        <path id="Shape 15" class="s0" d="" />
                        <path id="Shape 16" class="s0"
                            d="m1382.3 961.6l196.1 105.3c0 0 14.4 7.4 15.9 38.6 1.4 31.1 0 124.5 0 124.5 0 0-7.4-1.4-9.5 30.7l31.7-1.8c0 0 10.7-7.6 15.9-32.4 0 0 32.1-73.9 103.9-82.4 0 0 155.1-22.2 168.5 128.9 0 0 97.7 14.4 147.3-10.6l10.6-88.5c0 0-9-37.8-68.9-61.4-59.9-23.6-331.7-52.6-331.7-52.6 0 0-210.3-110.6-295.6-102.6z" />
                        <path id="Shape 17" class="s0"
                            d="m1947.2 1119.5c0 0 11-0.7 21.2 38.6 0 0-7.2 16.3 15.9 20.2h62.5c0 0-16-48.9-43.5-51.8-27.4-2.9-56.1-7-56.1-7z" />
                        <path id="Shape 18" class="s0"
                            d="m889.6 1289.6c0 0-0.6 9.6 29.7 9.7 30.2 0 591.3 0 591.3 0 0 0 11.1 5.1 26.5-13.2 0 0 3.5 24.2-9.6 44.8l-652.8 4.3c0 0-16.2 12 14.9-45.6z" />
                        <path id="Shape 8 copy" class="s0"
                            d="m396.8 302.7v85.1c0 0 2.5 16.1 41.3 17.5l56.2-2.6c0 0 31.1 5.9 44.5 17.5 0 0 166.1 82.6 243.7 91.2 0 0 17.5 8.3 6.4-21.9 0 0-87.9-147.7-39.2-177.1 0 0-153.2 20.7-169.6-104.4 0 0 8.7-16.7-28.6-15.8-37.2 0.9-143 0.9-143 0.9 0 0-20.6-3.9-36.1 44.7 0 0-13.1 28.1 24.4 64.9z" />
                        <path id="Shape 9 copy" class="s0"
                            d="m776.2 498.3l-127.2-78.1c0 0-24.1-11.8 3.2-24.5 0 0 44.9-7.1 77.4-1.8z" />
                        <path id="Shape 10 copy" class="s0" d="m872.6 499.2l-37.1-103.5 272.4-4.4-12.7 113.1z" />
                        <path id="Shape 11 copy" class="s0"
                            d="m404.2 385.1c0 0 54.8 5.2 61.5-6.1 6.7-11.3 3.2-34.2 3.2-34.2 0 0 2.8-13.2-24.4-11.4-27.2 1.8-43.5-1.8-43.5-1.8 0 0-11.2 63.3 3.2 53.5z" />
                        <path id="Shape 12 copy" class="s0"
                            d="m854.6 512.3c0 0 113.8 14.4 251.2 0 0 0 63.8-281.7 18-318.3l-200.3-1.8c0 0-35.3-5.3-41.3 36.8 0 0-13.9 37-74.2 78.1 0 0-35.2 24-3.2 86.8 32 62.8 49.8 118.4 49.8 118.4z" />
                        <path id="Shape 13 copy" class="s0"
                            d="m1174.6 499.2l20.2-107.9 293.5-10.5v14c0 0-155.4 111-313.7 104.4z" />
                        <path id="Shape 14 copy" class="s0"
                            d="m1155.6 508.8c0 0 55.4-294.9 19-314l331.7-1.7c0 0 36.7 1.3 38.2 43v122.7c0 0-50.6 72.1-217.3 129 0 0-63.9 30.8-171.6 21z" />
                        <path id="Shape 15 copy" class="s0" d="" />
                        <path id="Shape 16 copy" class="s0"
                            d="m1382.3 493.9l196.1-105.2c0 0 14.4-7.5 15.9-38.6 1.4-31.2 0-124.6 0-124.6 0 0-7.4 1.4-9.5-30.7l31.7 1.8c0 0 10.7 7.6 15.9 32.4 0 0 32.1 73.9 103.9 82.5 0 0 155.1 22.2 168.5-128.9 0 0 97.7-14.5 147.3 10.5l10.6 88.6c0 0-9 37.7-68.9 61.3-59.9 23.7-331.7 52.7-331.7 52.7 0 0-210.3 110.5-295.6 102.6z" />
                        <path id="Shape 17 copy" class="s0"
                            d="m1947.2 336c0 0 11 0.7 21.2-38.6 0 0-7.2-16.2 15.9-20.1h62.5c0 0-16 48.8-43.5 51.7-27.4 2.9-56.1 7-56.1 7z" />
                        <path id="Shape 18 copy" class="s0"
                            d="m889.6 165.9c0 0-0.6-9.6 29.7-9.7 30.2 0 591.3 0 591.3 0 0 0 11.1-5.1 26.5 13.2 0 0 3.5-24.2-9.6-44.7l-652.8-4.4c0 0-16.2-12 14.9 45.6z" />
                        <path id="Shape 19" fill-rule="evenodd" class="s0"
                            d="m1765.9 1354.1c-66.2 0-119.7-44.2-119.7-99 0-54.8 53.5-99 119.7-99 66.2 0 119.6 44.2 119.6 99 0 54.8-53.4 99-119.6 99z" />
                        <path id="Shape 20" fill-rule="evenodd" class="s0"
                            d="m716.5 298c-66.2 0-119.7-44.3-119.7-99 0-54.8 53.5-99.1 119.7-99.1 66.1 0 119.6 44.3 119.6 99.1 0 54.7-53.5 99-119.6 99z" />
                        <path id="Shape 21" fill-rule="evenodd" class="s0"
                            d="m1764.8 297c-66.2 0-119.7-44.2-119.7-99 0-54.7 53.5-99 119.7-99 66.1 0 119.6 44.3 119.6 99 0 54.8-53.5 99-119.6 99z" />
                        <path id="Shape 22" fill-rule="evenodd" class="s0"
                            d="m717.6 1356c-66.2 0-119.6-44.3-119.6-99 0-54.8 53.4-99 119.6-99 66.2 0 119.6 44.2 119.6 99 0 54.7-53.4 99-119.6 99z" />

                        <!-- Damage Anchors (View-Only) with Bootstrap Tooltips -->
                        @foreach ($damages as $damage)
                        <g>
                            <circle cx="{{ $damage['x'] }}"
                                cy="{{ $damage['y'] }}" r="35"
                                fill="{{ $damageTypes[$damage['type']]['color'] }}"
                                stroke="#333" stroke-width="4"
                                class="damage-point"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-html="true"
                                title="<strong>Type:</strong> {{ $damage['type'] }}<br><strong>Severity:</strong> {{ $damage['severity'] }}<br><strong>Body Part:</strong> {{ $damage['body_part'] }}@if($damage['remark'])<br><strong>Remark:</strong> {{ $damage['remark'] }}@endif">
                            </circle>
                            <text x="{{ $damage['x'] }}"
                                y="{{ $damage['y'] }}" text-anchor="middle"
                                dominant-baseline="central" fill="white" font-size="32"
                                font-weight="bold" style="pointer-events: none;">{{ strtoupper($damage['type']) }}</text>
                        </g>
                        @endforeach
                    </svg>
                </div>
            </div>

            <div class="table-section">
                <div class="table-header">
                    <h2>Damage Assessment Report</h2>
                </div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover damage-table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Damage Type</th>
                                    <th scope="col">Body Part</th>
                                    <th scope="col">Damage Level</th>

                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($damages as $damage)
                                <tr>
                                    <td><span class="badge bg-secondary">#{{ $loop->iteration }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="damage-type-indicator me-2 rounded-circle"
                                                style="width: 20px; height: 20px; background-color: {{ $damageTypes[$damage['type']]['color'] }};">
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ strtoupper($damage['type']) }}</div>
                                                <small class="text-muted">{{ $damageTypes[$damage['type']]['name'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $damage['body_part'] }}</td>
                                    <td>
                                        @php
                                        $badgeClass = match(strtolower($damage['severity'])) {
                                        'minor' => 'bg-success',
                                        'moderate' => 'bg-warning text-dark',
                                        'major', 'severe' => 'bg-danger',
                                        default => 'bg-info'
                                        };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($damage['severity']) }}
                                        </span>
                                    </td>
                                    <td>

                                        <p class="mb-0 small">{{ $damage['remark'] ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="display-1 mb-3">🚗</div>
                                            <p class="text-muted">No damage points were recorded for this inspection.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Tooltip Initialization --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    {{-- Custom Styles --}}
    <style>
        .main-content-view-only {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .car-container {
            position: relative;
        }

        .damage-point {
            cursor: help;
        }

        .damage-type-indicator {
            flex-shrink: 0;
        }

        .table-responsive {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .damage-table {
            margin-bottom: 0;
        }

        .empty-state {
            padding: 2rem;
        }

        /* Custom tooltip styling */
        .tooltip-inner {
            max-width: 250px;
            text-align: left;
        }
    </style>
</div>