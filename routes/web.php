<?php

use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/car-auctions', function () {
    return view('auctions');
})->name('auctions');

Route::get('/car-damage-test', function () {
    return view('carDamgeTest');
})->name('car.damage.test');


Route::get('/car-detail', function () {
    return view('detail');
})->name('car-detail-page');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

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
        Route::get('/car-damage-test', function () {
            return view('carDamgeTest');
        })->name('car.damage.test');
    });

    Route::view('sale', 'admin.sale')->name('admin.sale');
});
