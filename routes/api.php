<?php

use App\Http\Controllers\Api\Admin\ActivityLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\BidManagementController;
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
use App\Http\Controllers\Api\Admin\AgentManagementController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\PackageController;
use App\Http\Controllers\Api\Admin\ProfileController;
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
use App\Models\Package;

//Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

// Admin Panel Routes
Route::prefix('admin')
    ->middleware(['middleware' => 'auth:api'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('permission:dashboard-view');

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index']);
        Route::post('/activity-logs/delete', [ActivityLogController::class, 'bulkDelete']);

        // Role and Permissions
        Route::controller(RolePermissionController::class)->group(function () {
            Route::get('/roles', 'index')->middleware('permission:role-list');
            Route::get('/roles/show/{id}', 'show')->middleware('permission:role-manage');
            Route::post('/roles/create', 'store')->middleware('permission:role-manage');
            Route::post('/roles/update/{id}', 'update')->middleware('permission:role-manage');
            Route::post('/permissions/add/{id}', 'addPermissions')->middleware('permission:role-manage');
            Route::post('/permissions/remove/{id}', 'removePermissions')->middleware('permission:role-manage');
            Route::delete('/roles/delete/{id}', 'destroy')->middleware('permission:role-manage');
            Route::get('/permissions', 'getPermissions');
        });

        // User Management
        Route::controller(UserManagementController::class)->group(function () {
            Route::get('/users', 'index')->middleware('permission:user-list');
            Route::get('/users/show/{id}', 'show')->middleware('permission:user-manage');
            Route::post('/users/create', 'store')->middleware('permission:user-manage');
            Route::post('/users/update/{id}', 'update')->middleware('permission:user-manage');
            Route::patch('/users/toggle-approval/{id}', 'toggleApproval')->middleware('permission:user-manage');
            Route::delete('/users/delete/{id}', 'destroy')->middleware('permission:user-manage');
            Route::get('/users/roles', 'getRoles');
        });

        // Blogs Management
        Route::controller(BlogsController::class)->prefix('blogs')->group(function () {
            Route::get('/', 'index')->middleware('permission:blog-list');
            Route::get('/show/{id}', 'show')->middleware('permission:blog-list');
            Route::post('/create', 'store')->middleware('permission:blog-manage');
            Route::post('/update/{id}', 'update')->middleware('permission:blog-manage');
            Route::delete('/delete/{id}', 'destroy')->middleware('permission:blog-manage');
        });

        // Testimonials Management
        Route::controller(TestimonialsController::class)->prefix('testimonials')->group(function () {
            Route::get('/', 'index')->middleware('permission:testimonial-list');
            Route::get('/show/{id}', 'show')->middleware('permission:testimonial-list');
            Route::post('/create', 'store')->middleware('permission:testimonial-manage');
            Route::post('/update/{id}', 'update')->middleware('permission:testimonial-manage');
            Route::delete('/delete/{id}', 'destroy')->middleware('permission:testimonial-manage');
            Route::post('/toggle-status/{id}', 'toggleStatus')->middleware('permission:testimonial-manage');
        });

        // Contact Inquiries
        Route::controller(ContactSubmissionController::class)->group(function () {
            Route::get('/contact-enquiries', 'index')->middleware('permission:contact-inquiry-list');
            Route::get('/contact-enquiries/show/{id}', 'show')->middleware('permission:contact-inquiry-view');
            Route::delete('/contact-enquiries/delete/{id}', 'destroy')->middleware('permission:contact-inquiry-delete');
        });

        // Inspection Inquiries
        Route::controller(InspectionEnquiryController::class)->group(function () {
            Route::get('/inspection-enquiries', 'index')->middleware('permission:inspection-list');
            Route::get('/inspection-enquiries/show/{id}', 'show')->middleware('permission:inspection-view');
            Route::delete('/inspection-enquiries/delete/{id}', 'destroy')->middleware('permission:inspection-delete');
        });

        // Purchase Inquiries
        Route::controller(PurchaseEnquiryController::class)->group(function () {
            Route::get('/purchase-enquiries', 'index')->middleware('permission:purchase-inquiry-list');
            Route::get('/purchase-enquiries/show/{id}', 'show')->middleware('permission:purchase-inquiry-view');
            Route::delete('/purchase-enquiries/delete/{id}', 'destroy')->middleware('permission:purchase-inquiry-delete');
        });

        // Sale Inquiries
        Route::controller(SaleEnquiryController::class)->group(function () {
            Route::get('/sale-enquiries', 'index')->middleware('permission:sale-inquiry-list');
            Route::get('/sale-enquiries/show/{id}', 'show')->middleware('permission:sale-inquiry-view');
            Route::delete('/sale-enquiries/delete/{id}', 'destroy')->middleware('permission:sale-inquiry-delete');
        });

        // Bid Management
        Route::controller(BidManagementController::class)->group(function () {
            Route::get('/bids', 'index')->middleware('permission:bidding-list');
            Route::get('/bids/show/{id}', 'show')->middleware('permission:bidding-list');
            Route::patch('/bids/toggle-status/{id}', 'toggleStatus')->middleware('permission:bidding-actions');
            Route::patch('/bids/reject/{id}', 'reject')->middleware('permission:bidding-actions');
            Route::delete('/bids/delete/{id}', 'destroy')->middleware('permission:bidding-actions');
            Route::post('/bids/bulk-delete', 'bulkDelete')->middleware('permission:bidding-actions');
        });

        // Makes Management
        Route::controller(MakeController::class)->group(function () {
            Route::get('/makes', 'index')->middleware('permission:make-list');
            Route::get('/makes/show/{id}', 'show')->middleware('permission:make-list');
            Route::post('/makes/create', 'store')->middleware('permission:make-actions');
            Route::post('/makes/update/{id}', 'update')->middleware('permission:make-actions');
            Route::delete('/makes/delete/{id}', 'destroy')->middleware('permission:make-actions');
            Route::delete('/model/delete/{id}', 'deleteModel')->middleware('permission:make-actions');
            Route::get('/make-models/{id}', 'modelsByMake');
        });

        // Vehicles Management
        Route::prefix('vehicles')->controller(VehicleManagementController::class)->group(function () {
            Route::get('body-types', 'getBodyTypes');
            Route::get('fuel-types', 'getFuelTypes');
            Route::get('transmissions', 'getTransmissions');
            Route::get('features/simple', 'getAllFeatures');
            Route::get('features/exterior', 'getExteriorFeatures');
            Route::get('features/interior', 'getInteriorFeatures');
            Route::get('tags', 'getTags');
            Route::get('/', 'index')->middleware('permission:vehicle-list');
            Route::get('show/{id}', 'show')->middleware('permission:vehicle-view');
            Route::post('create', 'store')->middleware('permission:vehicle-create');
            Route::post('update/{id}', 'update')->middleware('permission:vehicle-edit');
            Route::post('images/add/{id}', 'addImages');
            Route::post('images/remove/{id}', 'removeImages');
            Route::delete('delete/{id}', 'destroy')->middleware('permission:vehicle-delete');
        });
        Route::controller(VehicleManagementController::class)->group(function () {
            Route::get('/auctions', 'auctions');
        });

        // Inspection Report Management
        Route::controller(InspectionReportController::class)->group(function () {
            Route::get('/inspection-reports', 'index')->middleware('permission:inspection-list');
            Route::get('/inspection-reports/show/{id}', 'show')->middleware('permission:report-view');
            Route::post('/inspection-reports/create', 'store')->middleware('permission:report-create');
            Route::post('/inspection-reports/upload-images', 'storeVehicleImages')->middleware('permission:report-edit');
            Route::post('/inspection-reports/remove-images', 'removeVehicleImages')->middleware('permission:report-edit');
            Route::post('/inspection-reports/field-images/add', 'storeInspectionFields')->middleware('permission:report-edit');
            Route::post('/inspection-reports/field-images/remove', 'removeInspectionFieldImages')->middleware('permission:report-edit');
            Route::get('/inspection-reports/damage-types', 'getDamageTypes');
            Route::post('/inspection-reports/damage/add', 'addDamage')->middleware('permission:report-edit');
            Route::post('/inspection-reports/damage/remove', 'removeDamage')->middleware('permission:report-edit');
            Route::post('/inspection-reports/update/{id}', 'update')->middleware('permission:report-edit');
            Route::delete('/inspection-reports/delete/{id}', 'destroy')->middleware('permission:report-delete');
            Route::post('/inspection-reports/generate-pdf/{id}', 'generatePdf')->middleware('permission:report-generate-pdf');
            Route::post('/inspection-reports/share-link/{id}', 'share')->middleware('permission:report-share');
            Route::get('/inspection-reports/download/{id}', 'downloadReport')->middleware('permission:report-download');
        });

        // Notifications
        Route::controller(NotificationController::class)->group(function () {
            Route::get('/notifications', 'index');
            Route::get('/notifications/get-all', 'allNotifications');
            Route::get('/notifications/get-unread', 'unreadNotifications');
            Route::put('/notifications/read/{id}', 'markAsRead');
            Route::post('/notifications/all-read', 'markAllAsRead');
            Route::delete('/notifications/delete/{id}', 'destroy');
            Route::delete('/notifications/clear', 'clearAll');
        });

        // Agents
        Route::controller(AgentManagementController::class)->group(function () {
            Route::get('/agents', 'index');
            Route::post('/agents/create', 'store');
            Route::get('/agents/show/{id}', 'show');
            Route::post('/agents/update/{id}', 'update');
            Route::post('/agents/assign-customers/{id}', 'assignCustomers');
            Route::get('/unassigned-customers/{id}', 'customersByAgent');
            Route::delete('/agents/delete/{id}', 'destroy');
        });

        // Packages
        Route::controller(PackageController::class)->group(function () {
            Route::get('/packages', 'index');
            Route::post('/packages/create', 'store');
            Route::get('/packages/show/{id}', 'show');
            Route::post('/packages/update/{id}', 'update');
            Route::delete('/packages/delete/{id}', 'destroy');
        });

        // Profile
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'index');
        });
    });





// Customer Panel Routes
Route::controller(VehicleController::class)->group(function () {
    //Vehicles

    Route::get('featured-vehicles', 'featuredVehicles')->name('featured.vehicles');
    Route::get('vehicles', 'getBuyVehicles')->name('vehicles');
    Route::get('sold-vehicles', 'getSoldVehicles')->name('sold.vehicles');
    Route::get('/vehicle/{id}', 'detail');

    //Auctions
    Route::get('auctions', 'getAuctionVehicles')->name('auctions-list');
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
