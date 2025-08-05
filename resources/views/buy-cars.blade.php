@extends('layouts.guest')
@section('title')
    Car Listings
@endsection
@section('content')
    @livewire('vehicle-and-auction-component', ['section' => 'Vehicles'])
@endsection
<script>
    // ===== VIEW SWITCHING FUNCTIONALITY ===== 
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('[data-view]');
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                viewButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const view = this.getAttribute('data-view');

                switch (view) {
                    case 'grid-large':
                        gridView.className = 'row g-4';
                        gridView.querySelectorAll('.col-md-6').forEach(col => {
                            col.className = 'col-lg-6';
                        });
                        showGridView();
                        break;
                    case 'grid':
                        gridView.className = 'row g-4';
                        gridView.querySelectorAll('.col-lg-6').forEach(col => {
                            col.className = 'col-md-6 col-lg-4';
                        });
                        showGridView();
                        break;
                    case 'grid-small':
                        gridView.className = 'row g-3';
                        gridView.querySelectorAll('.col-md-6').forEach(col => {
                            col.className = 'col-md-4 col-lg-3';
                        });
                        showGridView();
                        break;
                    case 'list':
                        showListView();
                        break;
                    case 'table':
                        // Implement table view
                        showGridView();
                        break;
                }
            });
        });

        function showGridView() {
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
        }

        function showListView() {
            gridView.classList.add('d-none');
            listView.classList.remove('d-none');
        }
    });
</script>
