@extends('admin.dashboard')

@section('title', 'Vehicle Details')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <livewire:admin.vehicle-detail-component :id="$id" />
            </div>
        </div>
    </div>
@endsection