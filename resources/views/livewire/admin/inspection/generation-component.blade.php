<div>


    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @php
    $user = auth()->guard('admin')->user();
    // Checks if the authenticated user has either 'super-admin' or 'admin' role.
    $isPrivilegedUser = $user && ($user->hasRole('super-admin'));
    @endphp

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
                @if($user->can('report-generate-pdf'))
                <button wire:click="generatePdf({{ $reportInView->id }})" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Generate PDF Report
                    <span wire:loading wire:target="generatePdf">
                        <div class="spinner-border" style="width: 15px; height: 15px;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                </button>
                @endif
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
            @if($linkedVehicleId==null && $linkedEnquiryId==null)
            @if($user->can('report-create'))
            <button wire:click="showCreateForm" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Report
            </button>
            @endif
            @endif
        </div>
        <div class="card-body">
            {{-- Search input --}}
            @if($linkedVehicleId==null && $linkedEnquiryId==null)
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by VIN or Make...">
                </div>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
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
                            <td>
                                @if($report->coverImage)
                                <img
                                    src="{{ asset('storage/' . $report->coverImage?->path) }}"
                                    alt="{{ $report->title }}"
                                    class="rounded"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $report->brand?->name }} {{ $report->vehicleModel?->name }}</td>
                            <td>{{ $report->vin }}</td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td>
                                {{-- This button now calls a Livewire action --}}
                                @if($user->can('report-view'))
                                <button wire:click="showReportDetails({{ $report->id }})" class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @endif
                                @if($user->can('report-edit'))
                                <button wire:click="showEditForm({{ $report->id }})" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif

                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">


                                    @if($report->file_path)
                                    @if($user->can('report-download'))
                                    <li>
                                        <div class="dropdown-item">
                                            <a href="{{asset('storage/'.$report->file_path)}}" target="_blank" class=" btn btn-outline-danger">
                                                <i class="fas fa-file-pdf me-2"></i> Download PDF
                                            </a>
                                        </div>

                                    </li>
                                    @endif
                                    @if($user->can('report-share'))
                                    <li>
                                        <div class="dropdown-item">
                                            <button wire:click="openShareModal({{ $report->id }})" class=" btn btn-outline-info">
                                                <i class="las la-share-alt me-2"></i> Share Report
                                            </button>
                                        </div>

                                    </li>
                                    @endif
                                    @endif
                                    @if($user->can('report-delete'))
                                    <li>
                                        <div class="dropdown-item">
                                            <button wire:click.prevent="$dispatch('confirmDelete', { id: {{ $report->id }} })"
                                                class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i> Delete Report
                                            </button>
                                        </div>

                                    </li>
                                    @endif
                                </ul>


                            </td>
                        </tr>
                        @empty
                        <tr>
                            @if($linkedVehicleId==null && $linkedEnquiryId==null)
                            <td colspan="5" class="text-center">No reports found.</td>
                            @else
                            @if($user->can('report-create'))
                            <button wire:click="showCreateForm" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Report
                            </button>
                            @endif
                            @endif
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>{{ $reports->links() }}</div>
        </div>
    </div>
    @endif
    {{-- Add this entire block at the bottom of generation-component.blade.php --}}
    @if ($showShareModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Sharable Link</h5>
                    <button type="button" wire:click="closeShareModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <p>Generate a secure, expirable link for Inspection Report #{{ $reportToShareId }}.</p>

                    <div class="form-group">
                        <label for="shareExpiryDateTime">Link Expiry Date & Time</label>
                        <input type="datetime-local" id="shareExpiryDateTime" class="form-control" wire:model="shareExpiryDateTime">
                        @error('shareExpiryDateTime') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button wire:click="generateShareableLink" class="btn btn-primary w-100 mt-3">
                        <span wire:loading.remove wire:target="generateShareableLink">
                            <i class="las la-link"></i> Generate Link
                        </span>
                        <span wire:loading wire:target="generateShareableLink">
                            Generating...
                        </span>
                    </button>

                    @if ($generatedShareLink)
                    <div class="mt-4">
                        <p class="mb-1"><strong>Link Generated:</strong></p>
                        <div class="input-group">
                            <input type="text" id="generated-share-link" class="form-control" value="{{ $generatedShareLink }}" readonly>
                            <button class="btn btn-outline--primary"
                                onclick="robustCopyToClipboard('generated-share-link')"
                                title="Copy to Clipboard">
                                <i class="las la-copy"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif


    <script>
        /**
         * A bulletproof copy-to-clipboard function that tries the modern API
         * and falls back to a legacy method if needed.
         */
        function robustCopyToClipboard(elementId) {
            const inputElement = document.getElementById(elementId);
            if (!inputElement) {
                console.error('Copy failed: Could not find element with ID:', elementId);
                return;
            }

            const textToCopy = inputElement.value;

            // --- Method 1: The Modern Clipboard API (Requires HTTPS or localhost) ---
            if (navigator.clipboard && window.isSecureContext) {
                console.log('Attempting to copy with modern API...');
                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        // Success feedback
                        window.dispatchEvent(new CustomEvent('success-notification', {
                            detail: {
                                message: 'Link copied to clipboard!'
                            }
                        }));
                    })
                    .catch(err => {
                        console.error('Modern API failed. This should not happen in a secure context.', err);
                        // If it fails for some reason, we can still try the fallback
                        fallbackCopyTextToClipboard(textToCopy);
                    });
            } else {
                // --- Method 2: The Fallback for insecure contexts (HTTP) ---
                console.log('Modern API not available. Using fallback method...');
                fallbackCopyTextToClipboard(textToCopy);
            }
        }

        /**
         * The fallback function that creates a temporary textarea.
         */
        function fallbackCopyTextToClipboard(text) {
            // Create a temporary textarea element
            const textArea = document.createElement("textarea");
            textArea.value = text;

            // Make it invisible and append it to the body
            textArea.style.position = "fixed";
            textArea.style.top = 0;
            textArea.style.left = 0;
            textArea.style.opacity = 0;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                // Try to execute the 'copy' command
                const successful = document.execCommand('copy');
                if (successful) {
                    window.dispatchEvent(new CustomEvent('success-notification', {
                        detail: {
                            message: 'Link copied to clipboard!'
                        }
                    }));
                } else {
                    throw new Error('Copy command was not successful.');
                }
            } catch (err) {
                console.error('Fallback copy failed:', err);
                window.dispatchEvent(new CustomEvent('error-notification', {
                    detail: {
                        message: 'Copy failed. Please copy the link manually.'
                    }
                }));
            }

            // Clean up and remove the temporary element
            document.body.removeChild(textArea);
        }
    </script>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    <script>
        function openImagesModal(startIndex = 0) {
            var myModal = new bootstrap.Modal(document.getElementById('imageSliderModal'));
            myModal.show();

            var carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('vehicleImagesCarousel'));
            carousel.to(startIndex);
        }

        function closeImagesModal() {
            var myModal2 = new bootstrap.Modal(document.getElementById('imageSliderModal'));
            myModal2.hide();


        }

        function jumpToImage(index) {
            var carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('vehicleImagesCarousel'));
            carousel.to(index);
        }
    </script>

    @endpush
</div>