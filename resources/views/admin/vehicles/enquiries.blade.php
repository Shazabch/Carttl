@extends('admin.dashboard')

@section('title', 'Vehicle Enquiries')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <livewire:admin.vehicle-enquiries-component :type="$type" /> 
            </div>
        </div>
    </div>
@endsection