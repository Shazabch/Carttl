@extends('account.layouts.app')
@section('title', 'Appointments - Dashboard')
@section('dashboard-content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">My Inspection Enquiries</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name & Phone</th>
                        <th>Email</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Use forelse to handle cases where there are no inspections --}}
                    @forelse($inspections as $item)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <div>{{ $item->user?->name }}</div>
                            <small class="text-muted">{{ $item->user?->phone }}</small>
                        </td>
                        <td>
                            {{ $item->email }}
                        </td>
                        <td>
                            {{ $item->brand?->name }}
                        </td>
                        <td>
                            {{ $item->vehicleModel?->name }}
                        </td>
                        <td class="text-center">{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>

                            @if($item->inspectionReport && $item->inspectionReport->shared_link)


                            <a href="{{ route('inspection.report.download', $item->inspectionReport->id) }}" class="btn btn-primary">
                                <i class="las la-download me-2"></i> Download Report
                            </a>
                            @else

                            <span class="badge bg-warning text-dark">Pending Inspection</span>
                            @endif
                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted">You have no inspection enquiries yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection