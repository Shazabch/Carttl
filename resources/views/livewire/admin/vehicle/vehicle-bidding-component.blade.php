<div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Manage Vehicle Bidding</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Bid Amount</th>
                        <th>Max Bid</th>
                        <th>Placed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bids as $item)
                    <tr>
                        <td>{{ $item->user?->name }}</td>
                        <td>{{ $item->bid_amount }}</td>
                        <td>{{ $item->max_bid }}</td>
                        <td>{{ $item->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>