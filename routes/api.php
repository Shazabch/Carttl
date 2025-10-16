<?php

use App\Http\Controllers\Api\Admin\BidManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\BlogsController;
use App\Http\Controllers\Api\Admin\ContactSubmissionController;
use App\Http\Controllers\Api\Admin\InspectionEnquiryController;
use App\Http\Controllers\Api\Admin\MakeController;
use App\Http\Controllers\Api\Admin\PurchaseEnquiryController;
use App\Http\Controllers\Api\Admin\RolePermissionController;
use App\Http\Controllers\Api\Admin\SaleEnquiryController;
use App\Http\Controllers\Api\Admin\TestimonialsController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\Admin\VehicleManagementController;
use App\Http\Controllers\Api\Admin\InspectionReportController;

use App\Http\Controllers\Api\Customer\BlogController;
use App\Http\Controllers\Api\Customer\TestimonialController;
use App\Http\Controllers\Api\Customer\VehicleController;
use App\Http\Controllers\Api\Customer\BiddingController;
use App\Http\Controllers\Api\Customer\BuyCarController;
use App\Http\Controllers\Api\Customer\ContactController;
use App\Http\Controllers\Api\Customer\FavoriteController;
use App\Http\Controllers\Api\Customer\InspectionController;
use App\Http\Controllers\Api\Customer\SellCarController;
use App\Http\Controllers\Api\Customer\UserDataController;


//Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

// Admin Panel Routes Start
Route::prefix('admin')
    ->middleware(['middleware' => 'auth:api'])
    ->group(function () {
        // Role and Permissions
        Route::controller(RolePermissionController::class)->group(function () {
            Route::get('/roles', 'index');
            Route::get('/roles/show/{id}', 'show');
            Route::post('/roles/create', 'store');
            Route::put('/roles/update/{id}', 'update');
            Route::delete('/roles/delete/{id}', 'destroy');
            Route::get('/permissions', 'getPermissions');
        });

        // User Management
        Route::controller(UserManagementController::class)->group(function () {
            Route::get('/users', 'index');
            Route::get('/users/show/{id}', 'show');
            Route::post('/users/create', 'store');
            Route::put('/users/update/{id}', 'update');
            Route::patch('/users/toggle-approval/{id}', 'toggleApproval');
            Route::delete('/users/delete/{id}', 'destroy');
            Route::get('/users/roles', 'getRoles');
        });

        //Blogs Management
        Route::controller(BlogsController::class)->prefix('blogs')->group(function () {
            Route::get('/', 'index');
            Route::get('/show/{id}', 'show');
            Route::post('/create', 'store');
            Route::post('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'destroy');
        });

        //Testimonials Management
        Route::controller(TestimonialsController::class)->prefix('testimonials')->group(function () {
            Route::get('/', 'index');
            Route::get('/show/{id}', 'show');
            Route::post('/create', 'store');
            Route::post('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'destroy');
            Route::post('/toggle-status/{id}', 'toggleStatus');
        });

        //Contact Inquiries
        Route::controller(ContactSubmissionController::class)->group(function () {
            Route::get('/contact-enquiries', 'index');
            Route::get('/contact-enquiries/show/{id}', 'show');
            Route::delete('/contact-enquiries/delete/{id}', 'destroy');
        });

        //Inspection Inquiries
        Route::controller(InspectionEnquiryController::class)->group(function () {
            Route::get('/inspection-enquiries', 'index');
            Route::get('/inspection-enquiries/show/{id}', 'show');
            Route::delete('/inspection-enquiries/delete/{id}', 'destroy');
        });

        //Purchase Inquiries
        Route::controller(PurchaseEnquiryController::class)->group(function () {
            Route::get('/purchase-enquiries', 'index');
            Route::get('/purchase-enquiries/show/{id}', 'show');
            Route::delete('/purchase-enquiries/delete/{id}', 'destroy');
        });

        //Sale Inquiries
        Route::controller(SaleEnquiryController::class)->group(function () {
            Route::get('/sale-enquiries', 'index');
            Route::get('/sale-enquiries/show/{id}', 'show');
            Route::delete('/sale-enquiries/delete/{id}', 'destroy');
        });

        //Bid Management
        Route::controller(BidManagementController::class)->group(function () {
            Route::get('/bids', 'index');
            Route::get('/bids/show/{id}', 'show');
            Route::patch('/bids/toggle-status/{id}', 'toggleStatus');
            Route::patch('/bids/reject/{id}', 'reject');
            Route::delete('/bids/delete/{id}', 'destroy');
            Route::post('/bids/bulk-delete', 'bulkDelete');
        });

        //Makes Management
        Route::controller(MakeController::class)->group(function () {
            Route::get('/makes', 'index');
            Route::get('/makes/show/{id}', 'show');
            Route::post('/makes/create', 'store');
            Route::post('/makes/update/{id}', 'update');
            Route::delete('/makes/delete/{id}', 'destroy');
        });

        //Model By Make
        Route::controller(MakeController::class)->group(function () {
            Route::get('/make-models/{id}', 'modelsByMake');
        });
        //Vehicles Management
        Route::controller(VehicleManagementController::class)->group(function () {
            Route::get('/vehicles', 'index');
            Route::get('/vehicles/show/{id}', 'show');
            Route::post('/vehicles/create', 'store');
            Route::post('/vehicles/update/{id}', 'update');
            Route::delete('/vehicles/delete/{id}', 'destroy');
        });

        //Inspection Report Management
        Route::controller(InspectionReportController::class)->group(function () {
            Route::get('/inspection-reports', 'index');
            Route::get('/inspection-reports/show/{id}', 'show');
            Route::post('/inspection-reports/create', 'store');
            Route::post('/inspection-reports/update/{id}', 'update');
            Route::delete('/inspection-reports/delete/{id}', 'destroy');

            Route::post('/inspection-reports/generate-pdf/{id}', 'generatePdf');
            Route::post('/inspection-reports/share-link/{id}', 'share');
            Route::get('/inspection-reports/download/{id}', 'downloadReport')
                ->name('inspection.report.download');
        });
    });




// Admin Panel Routes Start

// Customer Panel Routes Start
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

//Book inspection
Route::controller(InspectionController::class)->group(function () {
    Route::post('/inspection/submit', 'saveInspection')->name('inspection.submit');
});

//Sell Inquiry
Route::post('sell-car', [SellCarController::class, 'store'])->name('sell.car.store');
//Buy Inquiry
Route::post('buy-car', [BuyCarController::class, 'store']);

Route::group(['middleware' => 'auth:api'], function () {
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
    Route::controller(BiddingController::class)->group(function () {
        Route::get('/biddings/{vehicleId}', 'getVehicleBids');
        Route::post('/place-bid/{vehicleId}', 'placeBid');
        Route::get('/bid-history/{vehicleId}', 'getBidHistory');
    });
});
// Customer Panel Routes End
