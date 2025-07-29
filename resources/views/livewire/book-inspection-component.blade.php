<div>
    <section class="">
        <div class="container">
            <div class="row">
                @if ($formSubmitted)

                <div class="col-12">
                    <div class="card shadow-lg border-0 rounded-lg text-center p-4 p-md-5" style="transition: all 0.5s ease-in-out; opacity: 1;">
                        <div class="card-body">

                            <div class="fa-4x text-success mb-2">
                                <i class="fas fa-check-circle fa-beat text-success"></i>
                            </div>

                            <h1 class="display-5 fw-bold">Thank You, {{ $name }}!</h1>
                            <p class="lead text-muted mt-1">
                                Your vehicle inspection booking has been successfully submitted. Our team will contact you shortly to confirm the details.
                            </p>
                            <hr class="my-1">
                            <p>
                                If you have any urgent questions or need to reschedule, feel free to reach out to us anytime.
                            </p>
                            <p class="text-muted">
                                We appreciate your trust in our service.
                            </p>
                            <button wire:click="resetForm" class="btn btn-main mt-1">
                                <i class="fas fa-paper-plane me-2"></i>
                                Book Another Inspection
                            </button>
                        </div>
                    </div>
                </div>

                @else
                <div class="col-lg-8">
                    <div class="book-inspection-form">

                        <form wire:submit.prevent="saveInspection">
                            <h4 class="mb-4">Book Your Vehicle Inspection</h4>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="fullName" placeholder="Enter your name" wire:model="name">
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" placeholder="e.g. 0300 1234567" wire:model="phone">
                                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter your email" wire:model="email">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="vehicleType" class="form-label">Vehicle Type</label>
                                        <select class="form-select" id="vehicleType" wire:model="type">
                                            <option value="" selected disabled>Select vehicle type</option>
                                            <option>Car</option>
                                            <option>Van</option>
                                            <option>Truck</option>
                                            <option>Motorbike</option>
                                        </select>
                                        @error('type') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Preferred Date</label>
                                        <input type="date" class="form-control" id="date" wire:model="date">
                                        @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="time" class="form-label">Preferred Time</label>
                                        <input type="time" class="form-control" id="time" wire:model="time">
                                        @error('time') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="location" class="form-label">Location / Address</label>
                                        <input type="text" class="form-control" id="location" placeholder="Where should we inspect?" wire:model="location">
                                        @error('location') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="form-group">
                                        <label for="modelYear" class="form-label">Model Year</label>
                                        <input type="number" class="form-control" id="modelYear" placeholder="e.g. 2022" min="1990" max="2099" wire:model="year">
                                        @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="form-group">
                                        <label for="vehicleModel" class="form-label">Make</label>
                                        <input type="text" class="form-control" id="vehicleModel" placeholder="e.g. Corolla, Civic, Swift" wire:model="make">
                                        @error('make') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="form-group">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="number" class="form-control" id="model" placeholder="e.g. 2022" min="1990" max="2099" wire:model="model">
                                        @error('model') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <button type="submit" class="btn-main dark justify-content-center w-100">Submit Booking</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>