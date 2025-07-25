@extends('admin.dashboard')
@section('title', 'Vehicle Management')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @livewire('admin.sell.sell-list-management-component')
            </div>
        </div>
    </div>
@endsection
