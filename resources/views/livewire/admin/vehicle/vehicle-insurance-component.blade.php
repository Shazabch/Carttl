<div>
     <div class="card-header">
        <h5 class="mb-0">Manage Vehicle Insurance</h5>
    </div>
    <div class="card-body">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    </div>
</div>
