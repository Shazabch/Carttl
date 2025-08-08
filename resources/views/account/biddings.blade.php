@extends('account.layouts.app')
@section('title', 'Biddings - Dashboard')
@section('dashboard-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light"><h5 class="mb-0">My Biddings</h5></div>
        <div class="card-body">
           <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Bid Amount</th>
                            <th>Max Bid</th>
                            <th>VIN</th>
                            <th>Bid Time</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bids as $item)
                         <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{format_currency($item->bid_amount)}}
                            </td>
                            <td>
                                {{format_currency($item->max_bid)}}
                            </td>
                            <td>
                                <a href="{{route('car-detail-page' , $item->vehicle->id)}}">
                                    {{$item->vehicle->vin}}
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->bid_time)->format('Y-m-d') }}</td>
                            <td>{{$item->status}}</td>

                         </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection