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
                            <a class="nav-link {{ $activeTab == 'history' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('history')" href="#">
                                <i class="fas fa-history mx-2 text-dark"></i> History
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'inspection' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('inspection')" href="#">
                                <i class="fas fa-clipboard-check mx-2 text-dark"></i> Inspection
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'bidding' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('bidding')" href="#">
                                <i class="fas fa-gavel mx-2 text-dark"></i> Bidding
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'maintenance' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('maintenance')" href="#">
                                <i class="fas fa-tools mx-2 text-dark"></i> Maintenance Logs
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'insurance' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('insurance')" href="#">
                                <i class="fas fa-file-contract mx-2 text-dark"></i> Insurance
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'documents' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('documents')" href="#">
                                <i class="fas fa-folder-open mx-2 text-dark"></i> Documents
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'service_schedule' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('service_schedule')" href="#">
                                <i class="fas fa-calendar-check mx-2 text-dark"></i> Service Schedule
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-9">

            <div>

                <div>
                    @if ($activeTab == 'info')
                    <livewire:admin.vehicle.vehicle-detail-component :vehicleId="$vehicle->id" />
                    <livewire:admin.vehicle-form-component />

                    @elseif ($activeTab == 'assets')
                    <livewire:admin.vehicle.vehicle-assets-component :vehicleId="$vehicle->id" />

                    @elseif ($activeTab == 'history')
                    <livewire:admin.vehicle.vehicle-history-component :vehicleId="$vehicle->id" />

                    @elseif ($activeTab == 'inspection')
                    <livewire:admin.vehicle.vehicle-inspection-component :vehicleId="$vehicle->id" />

                    @elseif ($activeTab == 'bidding')
                    <livewire:admin.vehicle.vehicle-bidding-component :vehicleId="$vehicle->id" />
                    @elseif ($activeTab == 'maintenance')
                    <livewire:admin.vehicle.vehicle-maintenance-component :vehicleId="$vehicle->id" />

                    @elseif ($activeTab == 'insurance')
                    <livewire:admin.vehicle.vehicle-insurance-component :vehicleId="$vehicle->id" />
                    @elseif ($activeTab == 'documents')
                    <livewire:admin.vehicle.vehicle-documents-component :vehicleId="$vehicle->id" />

                    @elseif ($activeTab == 'service_schedule')
                    <livewire:admin.vehicle.vehicle-service-schedule-component :vehicleId="$vehicle->id" />

                    @endif
                </div>

            </div>
        </div>
    </div>
</div>