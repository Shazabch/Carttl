@extends('account.layouts.app')
@section('title', 'Enquiries - Dashboard')
@section('dashboard-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light"><h5 class="mb-0">My Enquiries</h5></div>
        <div class="card-body">
           <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                           
                            <th>VIN</th>
                            <th>Type</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $item)
                         <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                           
                            <td>
                               
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                            <td>{{$item->type}}</td>

                         </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection