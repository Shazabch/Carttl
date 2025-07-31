<?php

use App\Http\Controllers\admin\ContactSubmissionController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\VehicleManagerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/blog', 'blogs.index')->name('get-blog');
Route::view('/blog/details', 'blogs.details')->name('get-blog-details');
Route::view('/book-inspection', 'book-inspection')->name('book-inspection');

Route::view('/car-auctions', 'auctions')->name('auctions');
Route::view('/sell-cars', 'sell-cars')->name('sell-cars');
Route::view('/sell-car', 'sell-car')->name('sell-car');
Route::view('/car-favorites', 'favorites')->name('favorites');
Route::view('/car-detail', 'detail')->name('car-detail-page');
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
        Route::get('/vehicles', [VehicleManagerController::class, 'index'])->name('admin.vehicles');
        Route::get('/vehicles/{id}/details', [VehicleManagerController::class, 'details'])->name('admin.vehicles.details');
        Route::view('user', 'admin.user')->name('admin.user');
        Route::view('roles', 'admin.roles.index')->name('admin.roles');
        Route::view('sell-your-car', 'admin.sell.index')->name('admin.sell.index');
        Route::view('sell-car-lsiting', 'admin.sell.list')->name('admin.sell.list');
        Route::view('/blogs', 'admin.blogs.index')->name('admin.blogs');
        Route::view('/testimonials', 'admin.testimonials.index')->name('admin.testimonials');
        Route::view('/inspection-enquiries', 'admin.inspection.index')->name('admin.inspection.enquiries');
        Route::view('/inspection-generate', 'admin.inspection.generate-report')->name('admin.inspection.generate');

    });
});
Route::view('/un-authenticated', 'un-auth')->name('un-auth');
