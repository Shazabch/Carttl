<div>
     @if ($formSubmitted)
        <div class="card shadow-lg border-0 rounded-lg text-center p-4 p-md-5">
            <div class="card-body">
                <div class="fa-4x text-success mb-4">
                    <i class="fas fa-check-circle fa-beat"></i>
                </div>
                <h1 class="display-5 fw-bold">Thank You!</h1>
                <p class="lead text-muted mt-3">
                    Your vehicle enquiry has been submitted successfully. We will be in touch shortly.
                </p>
               
            </div>
        </div>
    @else
    <div class="vehicle-purchase-form p-3">


        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Enter your full name">
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="phone" wire:model.lazy="phone" name="phone" id="phone" class="form-control"
                placeholder="Enter your phone" required>
                 @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
         <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" wire:model.lazy="email" name="email" id="email" class="form-control"
                placeholder="Enter your email" required>
                 @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="address" wire:model.lazy="address" class="form-label">Address</label>
            <textarea name="address"  wire:model.lazy="address" id="address" rows="2" class="form-control"
                placeholder="Enter your address" required></textarea>
                 @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>


    </div>
    <!-- Buy It Now Card -->
    <div class="buy-now-card">
        <h4>Buy It Now</h4>
        <div class="buy-now-price">${{$selected_vehicle->price}}</div>
        <!-- <p>Skip the auction and purchase immediately</p> -->
        <button wire:click="saveBuyEnquiry" class="btn btn-warning btn-buy-now">
            <i class="fas fa-shopping-cart"></i>
            Buy It Now
        </button>
    </div>
@endif
</div>