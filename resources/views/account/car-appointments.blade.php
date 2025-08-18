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
                        <!-- <th>Action</th> -->


                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $item)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>
                            <div>{{($item->user?->name)}}</div>
                            <small class="text-muted">{{ $item->user?->phone }}</small>
                        </td>
                        <td>
                            {{($item->email)}}
                        </td>
                        <td>
                            {{$item->brand?->name}}

                        </td>

                        <td>{{$item->vehicleModel?->name}}</td>
                        <td class="text-center">{{ $item->created_at->format('Y-m-d') }}</td>
                        <!-- <td class="btn btn-primary text-light m-2">Download Report</td> -->

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection