@extends('layouts.admin.main')

@section('title', 'Bids')

@section('content')

<div class="row mx-2">
    <div class="col-12">
        @livewire('admin.manage-bids')
    </div>
</div>
@endsection