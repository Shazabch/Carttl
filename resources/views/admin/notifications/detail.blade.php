@extends('admin.dashboard')
@section('title', 'Notification Detail')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

               @livewire('admin.notifications.notification-detail-management-component')

            </div>
        </div>
    </div>
@endsection
