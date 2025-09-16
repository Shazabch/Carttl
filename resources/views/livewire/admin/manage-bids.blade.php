<div class="card-body">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button wire:click="deleteSelected"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete selected bids?') || event.stopImmediatePropagation()">
                Delete Selected
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hovered">
            <thead>
                <tr>
                    <th>
                       
                    </th>
                    <th>#</th>
                    <th>Vehicle</th>
                    <th>Bidder</th>
                    <th>Bid Amount</th>
                    <th>Max Bid</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bids as $bid)
                <tr>
                    <td>
                        <input type="checkbox"
                            wire:model="selected"
                            value="{{ $bid->id }}"
                            @if(in_array($bid->id, $selected)) checked @endif>
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $bid->vehicle?->brand?->name ?? 'N/A' }}
                        {{ $bid->vehicle?->vehicleModel?->name ?? 'N/A' }}
                        <br>
                        <a href="{{ route('admin.vehicles.details', ['id' => $bid->vehicle_id]) }}">
                            <span class="text-gray-500 text-xs">VIN: {{ $bid->vehicle->vin ?? 'N/A' }}</span>
                        </a>
                    </td>
                    <td>
                        {{ $bid->user->name ?? 'N/A' }}
                        <br>
                        <span class="text-gray-500 text-xs">{{ $bid->user->email ?? 'N/A' }}</span>
                    </td>
                    <td>{{ format_currency($bid->bid_amount) }}</td>
                    <td>{{ format_currency($bid->max_bid) }}</td>
                    <td>
                        <span class="badge
                            @if($bid->status === 'accepted') bg-success
                            @elseif($bid->status === 'pending') bg-warning
                            @else bg-danger @endif">
                            {{ ucfirst($bid->status) }}
                        </span>
                    </td>
                    <td>
                        <button wire:click="toggleBidStatus({{ $bid->id }})" class="btn btn-primary btn-sm">
                            @if($bid->status === 'accepted') Unapprove @else Approve @endif
                        </button>

                        @if($bid->status !== 'rejected')
                        <button wire:click="rejectBid({{ $bid->id }})"
                            onclick="return confirm('Reject this bid?') || event.stopImmediatePropagation()"
                            class="btn btn-warning btn-sm">
                            Reject
                        </button>
                        @endif

                        <button wire:click="deleteBid({{ $bid->id }})"
                            onclick="return confirm('Delete this bid?') || event.stopImmediatePropagation()"
                            class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No bids found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bids->links() }}
    </div>
</div>