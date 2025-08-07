@extends('admin.dashboard')
@section('title', 'Vehicle Management')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <livewire:admin.vehicle-form-component />
              
                @livewire('admin.vehicle-listing-component',['type' => $type])
            </div>
        </div>
    </div>
@endsection
