<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstantLogin extends Component
{
    public $email;
    public $password;

    public function loginUser()

    public function login()
    {
        // Validate inputs
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5'],
        ]);
        dd('dd');

        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();

            // Sync guest favorites
            $this->syncSessionFavorites($user);

            // Redirect to dashboard
             return redirect()->route('home');
        }

        session()->flash('error', 'Either email or password is incorrect.');
    }

    /**
     * Merges favorite vehicle IDs from the guest session into the user's
     * permanent database record.
     */
    private function syncSessionFavorites(User $user): void
    {
        if (session()->has('favorites')) {
            $guestFavorites = session('favorites', []);

            if (!empty($guestFavorites)) {
                $userFavorites = $user->favoriteVehicles()->pluck('vehicle_id')->toArray();

                $favoritesToSync = array_diff($guestFavorites, $userFavorites);

                if (!empty($favoritesToSync)) {
                    $user->favoriteVehicles()->attach($favoritesToSync);
                }
            }

            session()->forget('favorites');
        }
    }

   
    public function render()
    {
        return view('livewire.auth.instant-login');
    }
}