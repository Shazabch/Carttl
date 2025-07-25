<div>
    {{-- Page Header --}}
    <div class="card mb-5">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">{{ $vehicle->year }} {{ $vehicle->brand->name }} {{ $vehicle->vehicleModel->name }}</h3>
                <small class="text-muted">{{ $vehicle->title }}</small>
            </div>
            <a href="{{ route('admin.vehicles') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Sidebar Navigation --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'info' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('info')" href="#">
                                <i class="fas fa-photo-video mx-2 text-dark"></i> Details
                            </a>
                        </li>
                         <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'assets' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('assets')" href="#">
                                <i class="fas fa-photo-video mx-2 text-dark"></i> Assets
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'history' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('history')" href="#">
                                <i class="fas fa-history mx-2 text-dark"></i> History & Inspections
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-9">

            <div>
                @if ($activeTab == 'info')
                 <livewire:admin.vehicle.vehicle-detail-component :vehicleId="$vehicle->id" />
                 <livewire:admin.vehicle-form-component />
                @elseif($activeTab == 'assets')
                <livewire:admin.vehicle.vehicle-assets-component :vehicleId="$vehicle->id" />
                @elseif ($activeTab == 'history')
                <livewire:admin.vehicle.vehicle-history-component :vehicleId="$vehicle->id" />
                @endif
            </div>
        </div>
    </div>
</div>