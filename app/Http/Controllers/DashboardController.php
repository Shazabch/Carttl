<?php

namespace App\Http\Controllers;

use App\Models\VehicleBid;
use Illuminate\View\View;
use Illuminate\Http\Request;

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
        return view('account.notification-settings');
    }

    public function bidding(): View
    {
        $user_id = Auth()->user()->id;
        if (isset($user_id)) {
            $bids = VehicleBid::find($user_id)->get();
        } else {
            $bids = [];
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

    public function myJobApplications(): View
    {
        return view('account.my-job-applications');
    }

    public function carAppointments(): View
    {
        return view('account.car-appointments');
    }
}
