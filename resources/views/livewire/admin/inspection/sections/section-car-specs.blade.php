<div class="form-section">
    <div class="form-section-header">
        <h5>Car Specs</h5>
    </div>
    <div class="form-section-body">
        <div class="row">

            {{-- Parking Sensors --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Parking Sensors</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Front', 'Front & Rear', 'N/A'] as $option)
                            @php
                                $property = 'parkingSensors';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Keyless Start --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Keyless Start</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'Not Available'] as $option)
                            @php
                                $property = 'keylessStart';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Seats --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Seats</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Leather', 'Fabric', 'Alcantara'] as $option)
                            @php
                                $property = 'seats';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Cooled Seats --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Cooled Seats</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'Not Available'] as $option)
                            @php
                                $property = 'cooledSeats';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Heated Seats --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Heated Seats</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'Not Available'] as $option)
                            @php
                                $property = 'heatedSeats';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Power Seats --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Power Seats</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'Not Available'] as $option)
                            @php
                                $property = 'powerSeats';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Vive Camera --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Vive Camera</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Rear', 'Front &Rear', '360 degree'] as $option)
                            @php
                                $property = 'viveCamera';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sunroof Type --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Sunroof Type</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Panoramic', 'Dual', 'Normal', 'N/A', 'Moonroof'] as $option)
                            @php
                                $property = 'sunroofType';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Drive --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Drive</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['FWD', 'RWD', 'AWD', '4WD'] as $option)
                            @php
                                $property = 'drive';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Blind Spots --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Blind Spots</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'N/A'] as $option)
                            @php
                                $property = 'blindSpot';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Heads Up Display --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Heads Up Display</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'N/A'] as $option)
                            @php
                                $property = 'headsDisplay';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Premium Sound System --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Premium Sound System</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'N/A'] as $option)
                            @php
                                $property = 'premiumSound';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Carbon Fiber Interior --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Carbon Fiber Interior</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'N/A'] as $option)
                            @php
                                $property = 'carbonFiber';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Convertible --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Convertible</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Soft Top', 'Hard Top', 'Not Available'] as $option)
                            @php
                                $property = 'convertible';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Side steps --}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Side steps</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Available', 'Not Available'] as $option)
                            @php
                                $property = 'sideSteps';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
           {{-- soft door--}}
            <div class="col-md-6">
                <div class="form-item">
                    <label class="form-item-label">Soft Door Closing</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                        @foreach(['Yes', 'No'] as $option)
                            @php
                                $property = 'soft_door_closing';
                                $selected = ($reportData[$property] ?? null) === $option;
                                $class = $selected ? ($optionClasses[$option] ?? 'active-primary') : 'btn-light';
                            @endphp
                            <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')" class="btn {{ $class }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
           {{-- f-conclusion --}}
           <div class="col-md-12">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Final Conclusion', 'property' => 'final_conclusion'])
            </div>
        </div>
    </div>
</div>