<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Profile</h5>

            {{-- Success Indicator --}}
            <div x-data="{ show: @entangle('showSuccessIndicator') }"
                x-show="show"
                x-transition.out.opacity.duration.1500ms
                x-init="$watch('show', value => { if (value) { setTimeout(() => { show = false }, 2000) } })"
                class="text-success fw-bold" style="display: none;">
                <i class="fas fa-check-circle me-1"></i>
                Saved!
            </div>
        </div>

        {{-- Use an if/else to swap between viewing and editing states --}}
        @if ($isEditing)
        {{-- EDITING STATE --}}
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name')  @enderror" id="name" wire:model.defer="name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') @enderror" id="email" wire:model.defer="email">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div x-data="dubaiPhoneMask()" class="col-12">
                        <label for="phone" class="mt-1 form-label">Phone Number</label>
                        <input type="tel" id="phone" class="form-control" placeholder="+971 5xxxxxxxx"
                            x-model="phone" @input="formatPhone" wire:model.defer="phone">
                        @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="bio" class="form-label">Bio (Optional)</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" rows="4" wire:model.defer="bio" placeholder="Tell us a little about yourself..."></textarea>
                        @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" wire:click="cancel">Cancel</button>
                    <button type="submit" class="btn btn-accent">
                        {{-- Loading state indicator --}}
                        <span wire:loading.remove wire:target="save">Save Changes</span>
                        <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin me-2"></i>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
        @else
        {{-- VIEWING STATE --}}
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <img src="{{asset('assets/media/users/default.jpg')}}" class="rounded-circle me-3" alt="User Avatar">
                <div>
                    <h4 class="fw-bold text-primary mb-0">{{ $name }}</h4>
                    <p class="text-muted mb-0">Joined on {{ $user->created_at->format('F Y') }}</p>
                </div>
            </div>

            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th style="width: 120px;"><i class="fas fa-envelope fa-fw me-2 text-muted"></i>Email</th>
                        <td>{{ $email }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-phone fa-fw me-2 text-muted"></i>Phone</th>
                        <td>{{ $phone ?: 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-info-circle fa-fw me-2 text-muted"></i>Bio</th>
                        <td>{{ $bio ?: 'Not provided' }}</td>
                    </tr>
                </tbody>
            </table>

            <hr class="my-3">

            <div class="text-end">
                <button class="btn btn-accent" wire:click="edit">
                    <i class="fas fa-pencil-alt me-2"></i>Edit Profile
                </button>
            </div>
        </div>
        @endif
    </div>
</div>