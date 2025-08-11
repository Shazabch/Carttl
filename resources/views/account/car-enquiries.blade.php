@extends('account.layouts.app')
@section('title', 'Enquiries - Dashboard')
@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">My Enquiries</h5>
    </div>
    <div class="card-body">

        <!-- Toggle Buttons -->
        <ul class="nav nav-tabs mb-3" id="enquiryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="sale-tab" data-bs-toggle="tab" data-bs-target="#sale" type="button" role="tab">
                    Sale Enquiries
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="purchase-tab" data-bs-toggle="tab" data-bs-target="#purchase" type="button" role="tab">
                    Purchase Enquiries
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="enquiryTabsContent">

            <!-- Sale Enquiries -->
            <div class="tab-pane fade show active" id="sale" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Year</th>
                                <th>Specifications</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale_enquiries as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->brand->name }}</td>
                                <td>{{ $item->year }}</td>
                                <td>{{ $item->specification }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Purchase Enquiries -->
            <div class="tab-pane fade" id="purchase" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Year</th>
                                <th>Price</th>
                                <th>VIN</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buy_enquiries as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->vehicle?->title }}</td>
                                <td>{{ $item->vehicle?->year }}</td>
                                <td>{{ $item->vehicle?->Price }}</td>
                                 <td>
                                <a href="{{route('car-detail-page' , $item->vehicle->id)}}">
                                    {{$item->vehicle->vin}}
                                </a>
                            </td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
