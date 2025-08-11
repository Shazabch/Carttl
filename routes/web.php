<?php

use App\Http\Controllers\admin\ContactSubmissionController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\VehicleManagerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Livewire\Admin\Inspection\GenerationComponent;
use App\Models\Vehicle;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/blog/{slug}', [BlogController::class, 'blogDetails'])->name('get-blog');

Route::view('/book-inspection', 'book-inspection')->name('book-inspection');

Route::view('/car-auctions', 'auctions')->name('auctions');
Route::view('/buy-cars', 'buy-cars')->name('buy-cars');
Route::view('/sell-car', 'sell-car')->name('sell-car');
Route::view('/car-favorites', 'favorites')->name('favorites');
Route::get('/car-detail/{id}', [VehicleController::class, 'vehicleDetails'])->name('car-detail-page');
Route::view('/contact-us', 'contact-us')->name('contact-us');

// Route::group(['prefix' => 'account'], function(){
// Guest middleware
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [LoginController::class, 'index'])->name('account.login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('account.authenticate');
    Route::get('register', [LoginController::class, 'register'])->name('account.register');
    Route::post('register', [LoginController::class, 'processRegister'])->name('account.processRegister');
});
// Authenticate middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    Route::get('/account-settings', [DashboardController::class, 'accountSettings'])->name('account-settings');
    Route::get('/notification-settings', [DashboardController::class, 'notificationSettings'])->name('notification-settings');
    Route::get('/biddings', [DashboardController::class, 'bidding'])->name('biddings');
    Route::get('/my-ads', [DashboardController::class, 'myAds'])->name('my-ads');
    Route::get('/my-searches', [DashboardController::class, 'mySearches'])->name('my-searches');
    Route::get('/car-enquiries', [DashboardController::class, 'carEnquiries'])->name('car-enquiries');
    Route::get('/car-appointments', [DashboardController::class, 'carAppointments'])->name('car-appointments');
    Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
});

// });



Route::group(['prefix' => 'admin'], function () {
    // Guest middleware for admin
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('login', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    // Authenticate middleware for admin
    Route::group(['middleware' => 'admin.auth'], function () {


        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::view('/car-damage-test', 'carDamgeTest')->name('car.damage.test');

        Route::get('/submissions', [ContactSubmissionController::class, 'index'])->name('admin.submissions');
        Route::get('/vehicles', [VehicleManagerController::class, 'index'])->name('admin.vehicles.all');
        Route::get('/vehicles/{type}', [VehicleManagerController::class, 'index'])->name('admin.vehicles');
        Route::get('/vehicles/{id}/details', [VehicleManagerController::class, 'details'])->name('admin.vehicles.details');
        Route::view('user', 'admin.user')->name('admin.user');
        Route::view('roles', 'admin.roles.index')->name('admin.roles');
        Route::view('sell-your-car', 'admin.sell.index')->name('admin.sell.index');
        Route::view('purchase-car-lsiting', 'admin.purchase.list')->name('admin.purchase.list');
        Route::view('sell-car-lsiting', 'admin.sell.list')->name('admin.sell.list');
        Route::view('/blogs', 'admin.blogs.index')->name('admin.blogs');
        Route::view('/testimonials', 'admin.testimonials.index')->name('admin.testimonials');
        Route::view('/inspection-enquiries', 'admin.inspection.index')->name('admin.inspection.enquiries');
        Route::view('/inspection-generate', 'admin.inspection.generate-report')->name('admin.inspection.generate');
        Route::get('/inspection-generate/from-vehicle/{vehicle}',[VehicleManagerController::class, 'generateInspectionVehicle'])->name('admin.inspection.generate.from-vehicle');
        Route::get('/inspection-generate/from-enquiry/{enquiry}',[VehicleManagerController::class, 'generateInspectionEnquiry'])->name('admin.inspection.generate.from-enquiry');


    });
});
Route::view('/un-authenticated', 'un-auth')->name('un-auth');
