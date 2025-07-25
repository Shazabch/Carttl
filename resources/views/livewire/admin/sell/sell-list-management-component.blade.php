<div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Sale Enquiries</h4>

                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by Name, Number..." wire:model.live.debounce.300ms="search">
                </div>

                {{-- <button class="btn btn-primary" wire:click="addNew">
                    <i class="fas fa-plus-circle me-1"></i> Add Enquiry
                </button> --}}
            </div>

            <div class="card-body">
                {{-- @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Brand</th>
                                <th>Make</th>
                                <th>Mileage</th>
                                <th>Images</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($saleEnquiries as $index => $enquiry)
                                <tr wire:key="sale-enquiry-{{ $enquiry->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $enquiry->name }}</td>
                                    <td>{{ $enquiry->number }}</td>
                                    <td>{{ $enquiry->brand_id }}</td>
                                    <td>{{ $enquiry->make_id }}</td>
                                    <td>{{ $enquiry->mileage }}</td>
                                    <td>
                                        @if($enquiry->imageSet)
                                            <div class="d-flex flex-wrap justify-content-center gap-1">
                                                @foreach(range(1, 6) as $i)
                                                    @php $img = $enquiry->imageSet->{'image' . $i}; @endphp
                                                    @if($img)
                                                        <img src="{{ asset('storage/' . $img) }}"
                                                            width="50" height="50"
                                                            class="rounded shadow-sm"
                                                            style="object-fit: cover;" />
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">No Images</span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">No sale enquiries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $saleEnquiries->links() }}
            </div>
        </div>



</div>
