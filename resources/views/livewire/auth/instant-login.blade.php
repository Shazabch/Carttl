<div>

    <div class="login-form">
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="login">
            <div class="form-group">
                <label>Email</label>
                <input type="email" wire:model="email" class="form-control">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-2">
                <label>Password</label>
                <input type="password" wire:model="password" class="form-control">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="button" wire:click="loginUser" class="btn btn-primary mt-3">Login</button>
        </form>
    </div>



</div>