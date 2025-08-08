<?php

namespace App\Http\Controllers;

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

    public function security(): View
    {
        return view('account.security');
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
