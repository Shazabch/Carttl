<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;
use App\Models\Testimonial;
use App\Models\Vehicle;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuyCarController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\InspectionController;
use App\Http\Controllers\Api\SellCarController;
use App\Http\Controllers\Api\UserDataController;
use App\Livewire\ContactForm;

//Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);


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
    Route::get('blog/{slug}', 'blogDetail')->name('blog.detail');
    Route::get('blog/related/{slug}', 'relatedBlogs')->name('blog.related');
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




Route::group(['middleware' => 'auth:api'], function () {

    //Sell Inquiry
    Route::post('sell-car', [SellCarController::class, 'store'])->name('sell.car.store');
    //Buy Inquiry
    Route::post('buy-car', [BuyCarController::class, 'store']);

    Route::controller(FavoriteController::class)->group(function () {
        Route::get('favorites', 'index')->name('favorites.index');
        Route::post('favorites/toggle', 'toggle')->name('favorites.toggle');
        Route::delete('favorites/clear', 'clear')->name('favorites.clear');
    });
    Route::controller(UserDataController::class)->group(function () {
        Route::get('profile', 'profile')->name('profile');
        Route::post('user/profile/update', 'updateProfile');
        Route::post('user/profile/change-password', 'changePassword');
        Route::get('user/biddings', 'getUserBiddings')->name('user.biddings');
        Route::get('user/enquiries/purchase', 'getPurchaseEnquiries')->name('user.enquiries.purchase');
        Route::get('user/enquiries/sale', 'getSaleEnquiries')->name('user.enquiries.sale');
        Route::get('user/inspection-reports', 'getInspectionReports')->name('user.inspection.reports');
    });
});
