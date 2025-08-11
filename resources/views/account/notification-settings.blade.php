@extends('account.layouts.app')
@section('title', 'Notification - Dashboard')
@section('dashboard-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light"><h5 class="mb-0">My Notifications</h5></div>
        <div class="card-body">
           <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                        
                            <th>Title</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $item)
                         <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>{{$item->data['title']}}</td>
                            <td>{{$item->data['email']}}</td>
                            <td>{{$item->data['message']}}</td>
                            
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                           

                         </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection