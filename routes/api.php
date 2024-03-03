<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AppUser\appAuthController;
use App\Http\Controllers\AppUser\BookingController;
use App\Http\Controllers\AppUser\GeneralController;
use App\Http\Controllers\AppUser\AppUsersController;
use App\Http\Controllers\AppUser\UserProfileController;
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
    Route::post('/register', [AuthController::class, 'register']);
    //booking
    Route::post('booking', [BookingController::class, 'bookService']);
    Route::delete('/bookings/{id}', [BookingController::class, 'cancelBooking']);

    //General
    Route::get('/services', [GeneralController::class, 'getAllServices']);
    Route::get('/contact-us', [GeneralController::class, 'getContactUs']);
    Route::get('/about-us', [GeneralController::class, 'getAboutUs']);
    Route::get('/question', [GeneralController::class, 'getQuestion']);
    Route::get('/privacy', [GeneralController::class, 'getAllprivacy']);
    Route::get('/term', [GeneralController::class, 'getAllTerm']);
    Route::get('/setting', [GeneralController::class, 'getAllsetting']);
    //suscriptions
    Route::get('/suscriptions/{id}', [SubscriptionController::class,'show']);
    Route::get('/suscriptions', [SubscriptionController::class,'index']);
    Route::post('/booking-suscriptions', [SubscriptionController::class,'booking']);
    //user
    Route::get('/user/bookings', [BookingController::class, 'userBookings']);
    Route::get('/user/suscriptions', [SubscriptionController::class, 'userSuscriptions']);
    Route::get('/user-profile', [UserProfileController::class, 'index']);
    Route::post('/update-profile', [UserProfileController::class, 'updateProfile']);
    Route::get('/deactive-account', [UserProfileController::class, 'deactive_account']);
});

Route::get('/tabby-sucess', [BookingController::class,'sucess'])->name('success-ur');
Route::get('/tabby-cancel', [BookingController::class,'cancel'])->name('cancel-ur');
Route::get('/tabby-failure', [BookingController::class,'failure'])->name('failure-ur');
Route::get('/result', [BookingController::class,'tamaraResult'])->name('tammara-result');

require __DIR__ . '/dashboard.php';
