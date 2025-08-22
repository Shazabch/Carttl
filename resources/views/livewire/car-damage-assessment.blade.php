<div x-data="{
    mode: @entangle('mode'),
    currentDamageType: @entangle('currentDamageType'),
    currentSeverity: @entangle('currentSeverity'),
    showLabels: @entangle('showLabels'),
    tooltip: { show: false, x: 0, y: 0, damage: null },
    getBodyPart(x, y) {
        if (y < 400) return 'Hood';
        if (y > 1000) return 'Rear Bumper';
        return 'Door';
    },
     // A new function designed to be called directly from each path
    handlePartClick(partName, event) {
        if (this.mode !== 'add') return;

        console.log(`Clicked directly on part: ${partName}`);

        const svg = this.$refs.carSvg;
        const pt = svg.createSVGPoint();
        pt.x = event.clientX;
        pt.y = event.clientY;
        const cursorpt = pt.matrixTransform(svg.getScreenCTM().inverse());

        // We already know the partName, so we just pass it along
        this.$wire.addDamage(cursorpt.x, cursorpt.y, partName);
    },
    handleSvgClick(e) {
        if (this.mode !== 'add') return;
        const svg = this.$refs.carSvg;
        const pt = svg.createSVGPoint();
        pt.x = e.clientX;
        pt.y = e.clientY;
        const cursorpt = pt.matrixTransform(svg.getScreenCTM().inverse());
        const x = cursorpt.x;
        const y = cursorpt.y;
        const bodyPart = this.getBodyPart(x, y);
        this.$wire.addDamage(x, y, bodyPart);
    }
}" style="position: relative;" class="container">
    <link rel="stylesheet" href="{{ asset('css/car-damage-assessment.css') }}">
    <div class="main-content">
        <div class="controls-section-2">
            <div class="row">
                <div class="col-md-7">
                    <div class="damage-type-selection">
                        <h3 class="section-title">Select Damage Type</h3>
                        <div class="row">
                            @foreach ($damageTypes as $key => $type)
                            <div class="col-md-4 col-sm-6 mb-2">
                                <button wire:click="setCurrentDamageType('{{ $key }}')"
                                    class="damage-type-button {{ $currentDamageType === $key ? 'active' : '' }}">
                                    <div class="damage-type-content">
                                        <div class="damage-type-color" style="background-color: {{ $type['color'] }}"></div>
                                        <span class="damage-type-key">{{ strtoupper($key) }}</span>
                                        <span>{{ $type['name'] }}</span>
                                    </div>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="severity-selection">
                        <h3 class="section-title">Select Damage Level</h3>
                        <div class="row">
                            @foreach ($severityLevels as $key => $severity)
                            <div class="col-md-6">
                                <button wire:click="setCurrentSeverity('{{ $key }}')"
                                    class="severity-button {{ $currentSeverity === $key ? 'active' : '' }}">
                                    <div style="font-weight: 600;">{{ $severity['name'] }}</div>
                                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                                        {{ $severity['description'] }}
                                    </div>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="button-group">
                        <button wire:click="setMode('add')"
                            class="control-button mx-1 add {{ $mode === 'add' ? '' : 'inactive' }}">
                            <i class="fas fa-plus text-success"></i>
                        </button>
                        <button wire:click="setMode('remove')"
                            class="control-button mx-1 remove {{ $mode === 'remove' ? '' : 'inactive' }}">
                            <i class="fas fa-minus text-warning"></i>
                        </button>
                        <button wire:click="clearAll" class="control-button mx-1 clear">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                </div>
            </div>


        </div>
        <div class="car-section">
            <div class="car-container" :class="mode === 'add' ? 'add-mode' : ''">
                 @include('livewire.partials._car-diagram')

                <!-- Tooltip -->
                <div x-show="tooltip.show" x-transition
                    :style="`position: absolute; left: calc(${tooltip.x / 2560 * 100}% + 20px); top: calc(${tooltip.y / 1440 * 100}% - 20px); background: #fff; border: 1px solid #333; padding: 8px; z-index: 100; min-width: 180px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);`"
                    style="pointer-events: none;">
                    <div><strong>Type:</strong> <span x-text="tooltip.damage?.type"></span></div>
                    <div><strong>Severity:</strong> <span x-text="tooltip.damage?.severity"></span></div>
                    <div><strong>Body Part:</strong> <span x-text="tooltip.damage?.body_part"></span></div>
                    <div><strong>Position:</strong> X: <span x-text="tooltip.damage?.x"></span>, Y: <span
                            x-text="tooltip.damage?.y"></span></div>
                    <template x-if="tooltip.damage?.remark">
                        <div><strong>Remark:</strong> <span x-text="tooltip.damage?.remark"></span></div>
                    </template>
                </div>
            </div>
        </div>

        <div class="table-section">
            <div class="table-header">
                <h2>Damage Assessment Report</h2>
            </div>
            <div class="table-container">
                <table class="damage-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Damage Type</th>
                            <th>Body Part</th>
                            <th>Severity Level</th>
                            <!-- <th>Position</th> -->
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($damages as $damage)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>
                                <div class="damage-type-cell">
                                    <div class="damage-type-indicator"
                                        style="background-color: {{ $damageTypes[$damage['type']]['color'] }}">
                                    </div>
                                    <div>
                                        <div><strong>{{ strtoupper($damage['type']) }}</strong></div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">
                                            {{ $damageTypes[$damage['type']]['name'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $damage['body_part'] }}</td>
                            <td>
                                <span class="severity-badge severity-{{ $damage['severity'] }}">
                                    {{ $damage['severity'] }}
                                </span>
                            </td>
                            <!-- <td>
                                X: {{ round($damage['x']) }}<br>
                                Y: {{ round($damage['y']) }}
                            </td> -->
                            <td>
                                <textarea wire:change="updateRemark({{ $damage['id'] }}, $event.target.value)" class="remark-input"
                                    placeholder="Add remarks about this damage...">{{ $damage['remark'] ?? '' }}</textarea>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">🚗</div>
                                    <p>No damage points recorded yet.</p>
                                    <p style="font-size: 0.875rem; margin-top: 0.5rem;">Click on the car diagram to
                                        add damage points.</p>
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