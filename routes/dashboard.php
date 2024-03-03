<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PrivacyController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PaymentGatewayController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);


});
Route::group([
    'middleware' => 'api',
    'prefix' => 'dashboard'
], function ($router) {
    //users
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::get('getUserCount', [UserController::class, 'getUserCount']);
//roles
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/{role}', [RoleController::class, 'show']);
Route::post('/roles', [RoleController::class, 'store']);
Route::post('/roles/{role}', [RoleController::class, 'update']);
Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
//services
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);
Route::post('/services', [ServiceController::class, 'store']);
Route::post('/services/{service}', [ServiceController::class, 'update']);
Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
Route::get('getServicesCount', [ServiceController::class, 'getServiceCount']);
//about_us
Route::get('about-us', [AboutUsController::class, 'index']);
Route::post('about-us', [AboutUsController::class, 'update']);
//terms
Route::get('terms', [TermsController::class, 'index']);
Route::post('terms', [TermsController::class, 'update']);
//privacy
Route::get('privacies', [PrivacyController::class, 'index']);
Route::post('privacies', [PrivacyController::class, 'update']);
//questions
Route::get('questions', [QuestionController::class, 'index']);
Route::post('questions', [QuestionController::class, 'store']);
Route::get('questions/{question}', [QuestionController::class, 'show']);
Route::post('questions/{question}', [QuestionController::class, 'update']);
Route::delete('questions/{question}', [QuestionController::class, 'destroy']);
//Contact
Route::get('contact', [ContactController::class, 'index']);
Route::post('contact', [ContactController::class, 'update']);
//setting
Route::get('/setting', [SettingController::class, 'index']);
Route::post('/setting', [SettingController::class, 'store']);
//booking
Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings/{id}/status', [BookingController::class, 'changeBookingStatus']);
Route::get('/bookings/{id}', [BookingController::class, 'show']);
// subscriptionb
Route::post('/suscriptions', [SubscriptionController::class, 'createSubscriptions']);
Route::post('/subscriptions/{id}/status', [SubscriptionController::class,'updateSubscriptionStatus']);
Route::post('/subscriptions/{id}/update', [SubscriptionController::class,'updateSubscription']);
Route::get('/suscriptions/{id}', [SubscriptionController::class,'show']);
Route::get('/suscriptions', [SubscriptionController::class,'index']);


//payments getway
Route::get('/payments-getway', [PaymentGatewayController::class, 'index']);
Route::post('/tammara-update', [PaymentGatewayController::class, 'TammaraUpdate']);
Route::post('/tabby-update', [PaymentGatewayController::class, 'TabbyUpdate']);
});





