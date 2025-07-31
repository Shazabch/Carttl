@extends('layouts.guest')

@section('title')
    Car Detail
@endsection


@section('content')
    @livewire('Vehicle-detail-component')
@endsection
<script src="{{ asset('js/car-detail.js') }}"></script>
