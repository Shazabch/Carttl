<div class="card p-4">
    <div wire:loading wire:target="toggleBidStatus">
        <x-full-page-loading />
    </div>
    <h2 class="text-2xl font-bold mb-6">Manage Vehicle Bids</h2>

    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
    @endif
    @if (session()->has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif
    <div class="card-header d-flex justify-content-between align-items-center">

        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search bids..."
            class="form-control">

        <select wire:model.live="filterStatus"
            class="form-control p-2 mx-2">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="accepted">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <div class="card-body">


        <div class="table-responsive">
            <table class=" table table-hovered">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Vehicle</th>
                        <th>Bidder</th>
                        <th>Bid Amount</th>
                        <th>Max Bid</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                </thead>
                <tbody class="">
                    @forelse ($bids as $bid)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $bid->vehicle?->brand?->name ?? 'N/A' }} {{ $bid->vehicle?->vehicleModel?->name ?? 'N/A' }}
                            <br>
                            <a href="{{ route('admin.vehicles.details', ['id' => $bid->vehicle_id]) }}"><span class="text-gray-500 text-xs">VIN: {{ $bid->vehicle->vin ?? 'N/A' }}</span></a>
                        </td>
                        <td>
                            {{ $bid->user->name ?? 'N/A' }}
                            <br>
                            <span class="text-gray-500 text-xs">{{ $bid->user->email ?? 'N/A' }}</span>
                        </td>
                        <td>
                            {{ format_currency($bid->bid_amount) }}
                        </td>
                        <td>
                            {{ format_currency($bid->max_bid) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 badge text-white inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($bid->status === 'accepted') bg-success
                                @elseif($bid->status === 'pending') bg-warning
                                @else bg-danger  @endif">
                                @if($bid->status=='accepted')
                                Approved
                                @else
                                {{ ucfirst($bid->status) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="toggleBidStatus({{ $bid->id }})"
                                class="btn btn-primary">
                                @if($bid->status === 'accepted')
                                Unapprove
                                @else
                                Approve
                                @endif

                            </button>
                            @if($bid->status !== 'rejected')
                            <button wire:click="rejectBid({{ $bid->id }})"
                                onclick="return confirm('Are you sure you want to reject this bid?') || event.stopImmediatePropagation()"
                                class="btn btn-danger">
                                Reject
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No bids found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bids->links() }}
        </div>
    </div>
</div>