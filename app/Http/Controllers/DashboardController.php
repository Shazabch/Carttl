<?php

namespace App\Http\Controllers;

use App\Models\VehicleBid;
use App\Models\VehicleEnquiry;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('account.dashboard');
    }
    public function profile(): View
    {
        return view('account.profile');
    }

    public function accountSettings(): View
    {
        return view('account.account-settings');
    }

    public function notificationSettings(): View
    {
        $notifications = Auth::user()->notifications()->get();
        
        return view('account.notification-settings',compact('notifications'));
        
    }

    public function bidding(): View
    {
        $user_id = auth()->id();

        if ($user_id) {
            $bids = VehicleBid::where('user_id', $user_id)->get();
        } else {
            $bids = collect(); // empty collection, avoids errors in Blade
        }

        return view('account.biddings', compact('bids'));
    }


    public function myAds(): View
    {
        return view('account.my-ads');
    }

    public function mySearches(): View
    {
        return view('account.my-searches');
    }

    public function carEnquiries(): View
    {
        
          $user_id = auth()->id();
        if ($user_id) {
            $sale_enquiries = VehicleEnquiry::where('user_id', $user_id)->where('type', 'sale')->get();
            $buy_enquiries = VehicleEnquiry::where('user_id', $user_id)->where('type', 'purchase')->get();
        } else {
            $sale_enquiries = collect(); // empty collection, avoids errors in Blade
            $buy_enquiries = collect(); // empty collection, avoids errors in Blade
        }

        return view('account.car-enquiries', compact('sale_enquiries','buy_enquiries'));
    }

    public function carAppointments(): View
    {
        return view('account.car-appointments');
    }
}
