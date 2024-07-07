<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AppUser\CartController;
use App\Http\Controllers\APPUser\PointController;
use App\Http\Controllers\AppUser\ReviewController;
use App\Http\Controllers\AppUser\appAuthController;
use App\Http\Controllers\AppUser\BookingController;
use App\Http\Controllers\AppUser\GeneralController;
use App\Http\Controllers\AppUser\AppUsersController;
use App\Http\Controllers\AppUser\UserProfileController;
use App\Http\Controllers\AppUser\NotificationController;
use App\Http\Controllers\AppUser\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'app-user'
], function ($router) {
    //auth
    Route::post('/logout', [appAuthController::class, 'logout']);
    Route::post('/login', [appAuthController::class, 'login']);
    Route::post('/register', [appAuthController::class, 'register']);
    Route::post('/check_number', [AppUsersController::class, 'check_number']);
    Route::post('/check_opt', [AppUsersController::class, 'check_opt']);
    Route::post('/save-token', [AppUsersController::class, 'saveToken'])->name('save-token');
    //booking
    Route::post('booking', [BookingController::class, 'bookMultipleServices']);
    Route::delete('/bookings/{id}', [BookingController::class, 'cancelBooking']);
    Route::get('service-details/{service}', [BookingController::class, 'getServiceDetails']);
    ///coupon
   Route::post('check-coupon', [BookingController::class, 'checkCoupon']);
    //General
    Route::get('/services', [GeneralController::class, 'getAllServices'])->name('services');
    Route::get('/contact-us', [GeneralController::class, 'getContactUs']);
    Route::get('/about-us', [GeneralController::class, 'getAboutUs']);
    Route::get('/question', [GeneralController::class, 'getQuestion']);
    Route::get('/privacy', [GeneralController::class, 'getAllprivacy']);
    Route::get('/term', [GeneralController::class, 'getAllTerm']);
    Route::get('/setting', [GeneralController::class, 'getAllsetting']);
       ///////////////
    Route::get('/cities', [GeneralController::class, 'cities']);
    Route::get('/areas/{city_id}', [GeneralController::class, 'cityArea']);
    //suscriptions

    Route::get('/suscriptions/{id}', [SubscriptionController::class, 'show']);
    Route::get('/suscriptions', [SubscriptionController::class, 'index']);
    Route::post('/booking-suscriptions', [SubscriptionController::class, 'booking']);
    //user
    Route::get('/user/bookings', [BookingController::class, 'userBookings']);
    Route::get('/user/suscriptions', [SubscriptionController::class, 'userSuscriptions']);
    Route::get('/user-profile', [UserProfileController::class, 'index']);
    Route::post('/update-profile', [UserProfileController::class, 'updateProfile']);
    Route::get('/deactive-account', [UserProfileController::class, 'deactive_account']);

    ///notifications
    Route::get('/readNotifications-count', [NotificationController::class, 'count']);
    Route::get('/unreadNotifications-count', [NotificationController::class, 'unreadNotificationsCount']);
    Route::get('/notification-read', [NotificationController::class, 'NotificationRead']);
    Route::get('/notification-markasread', [NotificationController::class, 'MarkASRead']);
    Route::get('/notification-clear', [NotificationController::class, 'Clear']);

     //////////cart
     Route::post('addItemToCart', [CartController::class, 'addItemToCart']);
     Route::post('removeItemFromCart', [CartController::class, 'removeItemFromCart']);
     Route::get('getCartItems', [CartController::class, 'getCartItems']);
     Route::get('getUserCart', [CartController::class, 'getUserCart']);
     //reviews route
    Route::post('/review', [ReviewController::class, 'store']);
    Route::post('/review/{review}', [ReviewController::class, 'update']);
    Route::delete('/review/{review}', [ReviewController::class, 'destroy']);
    Route::get('/balance', [PointController::class, 'index']);
    /////////////////
    });
    Route::get('/tabby-sucess', [BookingController::class, 'sucess'])->name('success-ur');
    Route::get('/tabby-cancel', [BookingController::class, 'cancel'])->name('cancel-ur');
    Route::get('/tabby-failure', [BookingController::class, 'failure'])->name('failure-ur');
    Route::get('/paylink-result', [BookingController::class, 'paylinkResult'])->name('paylink-result');

    ////////////
    Route::get('/tabby-sucess-subscription', [SubscriptionController::class, 'sucess'])->name('success-ur-subscription');
    Route::get('/tabby-cancel-subscription', [SubscriptionController::class, 'cancel'])->name('cancel-ur-subscription');
    Route::get('/tabby-failure-subscription', [SubscriptionController::class, 'failure'])->name('failure-ur-subscription');
    Route::get('/paylink-result-subscription', [SubscriptionController::class, 'paylinkResult'])->name('paylink-result-subscription');

require __DIR__ . '/dashboard.php';
