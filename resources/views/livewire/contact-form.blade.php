<div class="container">

    @if ($formSubmitted)

        <div class="card shadow-lg border-0 rounded-lg text-center p-4 p-md-5"
            style="transition: all 0.5s ease-in-out; opacity: 1;">
            <div class="card-body">
                {{-- Use a Font Awesome icon with animation --}}
                <div class="fa-4x text-success mb-4">
                    <i class="fas fa-check-circle fa-beat"></i>
                </div>

                <h1 class="display-5 fw-bold">Thank You, {{ $firstName }}!</h1>
                <p class="lead text-muted mt-3">
                    Your message has been received. We appreciate you contacting us and will get back to you soon.
                </p>
                <hr class="my-4">
                <p>
                    Want to send another message?
                </p>

                {{-- This button will call the resetForm() method in the component --}}
                <button wire:click="resetForm" class="btn btn-outline-secondary mt-2">
                    <i class="fas fa-paper-plane me-2"></i>
                    Send Another Message
                </button>
            </div>
        </div>
    @else
        <form wire:submit="submit" novalidate>
            {{-- Error Message (for server issues, not validation) --}}
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- All your form fields go here, exactly as before --}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="firstName" class="mt-1 form-label">
                            First Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="firstName" class="form-control" placeholder="Enter your first name"
                            wire:model="firstName">
                        @error('firstName')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="lastName" class="mt-1 form-label">
                            Last Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="lastName" class="form-control" placeholder="Enter your last name"
                            wire:model="lastName">
                        @error('lastName')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="email" class="mt-1 form-label">
                            Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" id="email" class="form-control" placeholder="your.email@example.com"
                            wire:model="email">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <div x-data="dubaiPhoneMask()" class="form-group mb-3">
                            <label for="phone" class="mt-1 form-label">Phone Number</label>
                            <input type="tel" id="phone" class="form-control" placeholder="+971 5xxxxxxxx"
                                x-model="phone" @input="formatPhone" wire:model.lazy="phone">
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="message" class="mt-1 form-label">
                            Message <span class="text-danger">*</span>
                        </label>
                        <textarea id="message" class="form-control" rows="5" placeholder="Please provide details..."
                            wire:model.lazy="message"></textarea>
                        @error('message')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" id="terms" wire:model="terms">
                <label class="form-check-label text-muted" for="terms">
                    I agree to the <a href="#" class="text-warning text-decoration-none">Terms of Service</a> and
                    <a href="#" class="text-warning text-decoration-none">Privacy Policy</a>
                    <span class="text-danger">*</span>
                </label>
                @error('terms')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                <button type="submit" class="btn-main dark" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        <i class="fas fa-paper-plane me-1"></i> Send Message
                    </span>
                    <span wire:loading wire:target="submit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Sending...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
