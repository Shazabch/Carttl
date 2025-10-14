<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;
use App\Models\Testimonial;
use App\Models\Vehicle;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InspectionController;
use App\Livewire\ContactForm;

//Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::controller(VehicleController::class)->group(function () {
    //Vehicles
    Route::get('all-vehicles', 'getAllVehicles')->name('all.vehicles');
    Route::get('featured-vehicles', 'featuredVehicles')->name('featured.vehicles');
    Route::get('vehicles', 'getBuyVehicles')->name('vehicles');
    Route::get('sold-vehicles', 'getSoldVehicles')->name('sold.vehicles');
    Route::get('/vehicle/{id}', 'detail');

    //Auctions
    Route::get('auctions', 'getAuctionVehicles')->name('auctions');
    Route::get('featured-auctions', 'featuredAuctions')->name('featured.auctions');

    //Makes
    Route::get('featured-makes', 'featuredMakes')->name('featured.makes');
    Route::get('all-makes', 'getAllMakes')->name('all.makes');
    //Years
    Route::get('years', 'getYears')->name('years');
    //Models
    Route::get('/models/{makeId}', 'getModelsByMake')->name('models');
});


//Blogs
Route::controller(BlogController::class)->group(function () {


    Route::get('featured-blog', 'featuredBlog')->name('featured.blogs');
    Route::get('blogs', 'getAllBlogs')->name('blogs');
});


// Testimonials
Route::controller(TestimonialController::class)->group(function () {


    Route::get('testimonials', 'getAllTestimonials')->name('testimonials');
});


// contact
Route::controller(ContactController::class)->group(function () {

    Route::post('/contact/submit', 'submit')->name('contact.submit');
});


// inspection
Route::controller(InspectionController::class)->group(function () {
    Route::post('/inspection/submit', 'saveInspection')->name('inspection.submit');
});

Route::group(['middleware' => 'auth:api'], function () {});
