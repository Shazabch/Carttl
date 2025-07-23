@extends('admin.dashboard')
@section('title', 'Contact Submission List')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mb-4">Contact Form Submissions</h1>

            {{-- This is where the magic happens. We're embedding the Livewire component. --}}
            <livewire:admin.submission-list />

        </div>
    </div>
</div>
@endsection