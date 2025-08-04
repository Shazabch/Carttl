@extends('layouts.admin.main')

@section('title', 'Inspection Generation ')

@section('content')
 <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Inspection Management</h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class=" font-weight-bold mr-4">Vehicle Inspection Generation - {{$detailsItem}}</span>

            </div>
            <div class="d-flexs align-items-center">

            </div>
        </div>
    </div>
 <div class="container">
        <div class="row">
            <div class="col">
                @livewire('admin.inspection.generation-component', ['vehicleId' => $id])
            </div>
        </div>
    </div>

@endsection
