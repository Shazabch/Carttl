@extends('admin.dashboard')
@section('title', 'Vehicle Management')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <livewire:admin.make-form-component />
              
                @livewire('admin.make-listing-component')
            </div>
        </div>
    </div>
@endsection
