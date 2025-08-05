<div>
    <div wire:loading wire:target="generatePdf,nextStep">
        <x-full-page-loading />
    </div>
    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($showForm)
    {{-- ======================================================= --}}
    {{-- STATE 1: THE WIZARD FORM (CREATE/EDIT)        --}}
    {{-- ======================================================= --}}

    @include('livewire.admin.inspection.wizard-form')

    @elseif($showDetails)
    {{-- ======================================================= --}}
    {{-- STATE 2: THE DETAILED REPORT VIEW           --}}
    {{-- ======================================================= --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Inspection Report Details</h4>
                <p class="mb-0 text-muted">Report ID: {{ $reportInView->id }}</p>
            </div>
            <div>
                {{-- This button now calls a Livewire action --}}
                <button wire:click="generatePdf({{ $reportInView->id }})" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </button>
                <button wire:click="cancel" class="btn btn-secondary">Back to List</button>
            </div>
        </div>
        <div class="card-body">
            {{-- Reuse the same PDF template for the view content --}}
            @include('admin.inspection.report-pdf-template', ['report' => $reportInView])
        </div>
    </div>

    @else
    {{-- ======================================================= --}}
    {{-- STATE 3: THE LIST OF ALL REPORTS          --}}
    {{-- ======================================================= --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Inspection Reports</h4>
            <button wire:click="showCreateForm" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Report
            </button>
        </div>
        <div class="card-body">
            {{-- Search input --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by VIN or Make...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Make & Model</th>
                            <th>VIN</th>
                            <th>Inspected At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->make }} {{ $report->model }}</td>
                            <td>{{ $report->vin }}</td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td>
                                {{-- This button now calls a Livewire action --}}
                                <button wire:click="showReportDetails({{ $report->id }})" class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button wire:click="generatePdf({{ $report->id }})" class="btn btn-sm btn-outline-danger" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                                <button wire:click="showEditForm({{ $report->id }})" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteReport({{ $report->id }})"
                                    wire:confirm="Are you sure?"
                                    class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>{{ $reports->links() }}</div>
        </div>
    </div>
    @endif

    <style>
        /* =================================================================== */
        /*                          Wizard Progress Bar                        */
        /* =================================================================== */
        .wizard-progress {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 0;
            padding: 0;
        }

        /* The grey line that runs behind the steps */
        .wizard-progress::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #e9ecef;
            z-index: 1;
        }

        /* The blue progress line that fills up */
        .progress-bar-line {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            background-color: #0d6efd;
            /* Bootstrap Primary Blue */
            z-index: 2;
            transition: width 0.4s ease-in-out;
        }

        .wizard-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 3;
            width: 33.33%;
        }

        .wizard-step .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            /* Light Grey */
            color: #495057;
            /* Dark Grey Text */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 3px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .wizard-step .step-label {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #6c757d;
            /* Muted Grey Text */
        }

        /* Active Step Styling */
        .wizard-step.active .step-icon {
            border-color: #0d6efd;
            /* Blue Border */
            background-color: #fff;
            /* White Background */
            color: #0d6efd;
            /* Blue Text/Icon */
        }

        .wizard-step.active .step-label {
            color: #0d6efd;
            /* Blue Text */
            font-weight: 600;
        }

        /* Completed Step Styling */
        .wizard-step.completed .step-icon {
            border-color: #0d6efd;
            /* Blue Border */
            background-color: #0d6efd;
            /* Blue Background */
            color: #fff;
            /* White Text/Icon */
        }

        .wizard-step.completed .step-label {
            color: #212529;
            /* Black Text */
        }


        /* =================================================================== */
        /*                          Form Element Styling                       */
        /* =================================================================== */
        .space-y-4>*:not(:last-child) {
            margin-bottom: 1.5rem;
            /* Creates space between sections */
        }

        .form-section {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #dee2e6;
        }

        .form-section-header {
            background-color: #4a148c;
            /* Deep Purple */
            color: white;
            padding: 1rem 1.25rem;
            border-top-left-radius: calc(0.5rem - 1px);
            border-top-right-radius: calc(0.5rem - 1px);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-section-header h5 {
            margin-bottom: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .form-section-body {
            padding: 1.5rem;
        }

        .form-item {
            background-color: #f8f9fa;
            /* Very light grey */
            border: 1px solid #e9ecef;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            /* Space between items inside a section */
        }

        .form-section-body .row>div:last-child .form-item,
        .form-section-body>.form-item:last-child {
            margin-bottom: 0;
        }

        .form-item-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.75rem;
            display: block;
            font-size: 0.9rem;
        }


        /* --- Single Toggle Buttons (Yes/No, Available/Unavailable) --- */
        .btn-group-toggle .btn {
            border: 1px solid #ced4da;
            box-shadow: none !important;
            /* Remove Bootstrap's default focus shadow */
        }

        /* Style for selected "positive" options */
        .btn-group-toggle .btn.active-green {
            background-color: #198754;
            /* Bootstrap Success Green */
            color: white;
            border-color: #198754;
        }

        /* Style for selected "negative" options */
        .btn-group-toggle .btn.active-red {
            background-color: #dc3545;
            /* Bootstrap Danger Red */
            color: white;
            border-color: #dc3545;
        }


        /* --- Multi-Select Tags (e.g., Paint Condition) --- */
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 0.3em 0.75em;
            font-size: 85%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .tag-red {
            background-color: #dc3545;
        }

        .tag-green {
            background-color: #198754;
        }

        .tag-gray {
            background-color: #6c757d;
        }

        .tag-blue {
            background-color: #0d6efd;
        }

        .tag-purple {
            background-color: #6f42c1;
        }


        /* --- Modal Select Button and Styling --- */
        .select-response-btn {
            background-color: #6f42c1;
            /* Indigo/Purple */
            color: white;
            width: 100%;
        }

        .select-response-btn:hover {
            background-color: #5a3d99;
            color: white;
        }

        .min-h-25px {
            min-height: 25px;
            /* Ensures the container doesn't collapse when empty */
        }

        /* Ensure the modal appears above everything */
        .modal-backdrop {
            z-index: 1040;
        }

        .modal {
            z-index: 1050;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @push('scripts')
    <script>
        // Listen for the 'livewire:initialized' event to ensure Livewire is ready
        document.addEventListener('livewire:initialized', () => {
            // Listen for the 'confirmDelete' event dispatched from the delete icon
            @this.on('confirmDelete', ({
                id
            }) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // If the user confirms, dispatch another event to the component to trigger the deletion
                    if (result.isConfirmed) {
                        @this.dispatch('deleteReport', {
                            id: id
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</div>