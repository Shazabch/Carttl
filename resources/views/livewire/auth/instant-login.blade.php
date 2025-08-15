<div>
   <div>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="login">
        <div class="row gy-3 overflow-hidden">
            <div class="col-12">
                <div>
                    <label for="email" class="form-label fw-medium">Email Address</label>
                    <input type="text"
                           wire:model="email"
                           id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="name@example.com">
                    @error('email') <p class="invalid-feedback">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-12">
                <div>
                    <label for="password" class="form-label fw-medium">Password</label>
                    <input type="password"
                           wire:model="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password">
                    @error('password') <p class="invalid-feedback">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                </div>
                <div class="text-center mt-4 text-secondary">
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-3">Sign In</button>
                     <p>Don't have an account? <a href="{{ route('account.register') }}"
                                    class="text-warning fw-medium text-decoration-none">Create an
                                    account</a></p>
                </div>
            </div>
        </div>
    </form>
</div>


</div>