<div>
    @php
    $user = auth()->guard('admin')->user();
    // Checks if the authenticated user has either 'super-admin' or 'admin' role.
    $isPrivilegedUser = $user && ($user->hasRole('super-admin'));
    @endphp

    {{-- Page Header --}}
    <div class="card mb-5">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-primary mx-2" wire:click.prevent="cycleSidebarState" title="Toggle Sidebar View">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Left Sidebar Navigation --}}
        @if ($sidebarState !== 'hidden')
        <div class="{{ $sidebarState === 'full' ? 'col-md-3' : 'col-auto' }}">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        @if ($isPrivilegedUser || $user->can('sale-inquiry-list'))
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'sale' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('sale')" href="#" title="Sale">
                                <i class="fas fa-car mx-2 text-dark"></i>
                                @if ($sidebarState === 'full')
                                Sale
                                @endif
                            </a>
                        </li>
                        @endif
                        @if ($isPrivilegedUser || $user->can('purchase-inquiry-list'))
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ $activeTab == 'purchase' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('purchase')" href="#" title="purchase">
                                <i class="fas fa-photo-video mx-2 text-dark"></i>
                                @if ($sidebarState === 'full')
                                Purchase
                                @endif
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @endif
        <div class="{{ $this->getMainContentGridClass() }}">

            <div>

                <div>
                    @if ($activeTab == 'sale')
                    @if ($isPrivilegedUser || $user->can('sale-inquiry-list'))
                    @livewire('admin.sell.sell-list-management-component')
                    @endif
                    @elseif ($activeTab == 'purchase')
                    @if ($isPrivilegedUser || $user->can('purchase-inquiry-list'))
                    @livewire('admin.purchase.purchase-list-management-component')
                    @endif
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>