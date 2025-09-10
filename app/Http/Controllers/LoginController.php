<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\AccountCreatedConfirmation;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    // This method will show login page for customer
    public function index(Request $request)
    {
        // Save intended URL if provided via ?redirect= or fallback to previous page
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        } elseif (url()->previous() !== url()->current()) {
            session(['url.intended' => url()->previous()]);
        }

        return view('account.login');
    }

    public function register(Request $request)
    {
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        } elseif (url()->previous() !== url()->current()) {
            session(['url.intended' => url()->previous()]);
        }

        return view('account.register');
    }


    public function authenticate(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:5',
            'g-recaptcha-response' => ['accepted'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // --- MODIFICATION START ---
            // Get the user that was just authenticated
            $user = Auth::user();

            // Sync guest favorites from the session to the user's database record
            $this->syncSessionFavorites($user);
            // --- MODIFICATION END ---

            return redirect()->intended();
        } else {
            return redirect()->route('account.login')->with('error', 'Either email or password is incorrect.');
        }
    }



    public function processRegister(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
            'g-recaptcha-response' => ['accepted'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'customer';
        $user->save();
        Notification::send($user, new AccountCreatedConfirmation($user, $request->password));
        $user->syncRoles('customer');
        // This is only necessary if you are using a third-party roles package like Spatie
        // If not, you can remove this line.
        // $user->syncRoles('customer');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $this->syncSessionFavorites($user);
            return redirect()->intended();
        } else {
            return redirect()->route('account.login')->with('error', 'Either email or password is incorrect.');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    /**
     * ** ---- NEW HELPER METHOD ---- **
     *
     * Merges favorite vehicle IDs from the guest session into the user's
     * permanent database record.
     *
     * @param  \App\Models\User $user The user to sync favorites for.
     * @return void
     */
    private function syncSessionFavorites(User $user): void
    {
        // Check if there are any guest favorites in the session
        if (session()->has('favorites')) {
            $guestFavorites = session('favorites', []);

            if (!empty($guestFavorites)) {
                // Get the user's current favorites from the database to avoid duplicates
                $userFavorites = $user->favoriteVehicles()->pluck('vehicle_id')->toArray();

                // Find which session favorites are not already in the user's DB favorites
                $favoritesToSync = array_diff($guestFavorites, $userFavorites);

                if (!empty($favoritesToSync)) {
                    // Attach only the new favorites to the user's record
                    $user->favoriteVehicles()->attach($favoritesToSync);
                }
            }

            // Important: Clear the session favorites now that they are saved to the database
            session()->forget('favorites');
        }
    }
}
