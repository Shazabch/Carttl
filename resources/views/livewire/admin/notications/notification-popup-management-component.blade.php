<div>
    @forelse ($notifications as $notification)
        <div class="alert alert-light border mb-2 d-flex justify-content-between align-items-start">
            <div>
                <strong>{{ $notification->data['title'] }}</strong><br>
                Name: {{ $notification->data['name'] }}<br>
                Message: {{ $notification->data['message'] }}<br>
                <div class="text-muted small mt-1">
                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                </div>

            </div>

            <!-- Dismiss Icon -->
            <div wire:click="removeNotification('{{ $notification->id }}')" class=" text-light ml-2 "
            title="Dismiss"  style="cursor: pointer;">
                <i class="fas fa-times"></i>
            </div>
        </div>
    @empty
        <div class="text-muted">No notifications found.</div>
    @endforelse
</div>
