@extends('layouts.guest')

@section('title')
    Car Detail
@endsection


@section('content')
    @livewire('vehicle-detail-component',['id' => $id])
@endsection
<script src="{{ asset('js/car-detail.js') }}"></script>
