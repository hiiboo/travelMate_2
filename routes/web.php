<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\OrganizerLoginController;
use \App\Http\Controllers\Auth\OrganizerRegisterController;
use \App\Http\Controllers\Auth\OrganizerLogoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    // User Routes
    // Route::post('user/login', UserLoginController::class)->middleware('guest');
    // Route::post('user/register', UserRegisterController::class)->middleware('guest');
    // Route::post('user/logout', UserLogoutController::class)->middleware('auth:web');

    // Organizer Routes
    Route::post('organizer/login', OrganizerLoginController::class)->middleware('guest');
    Route::post('organizer/register', OrganizerRegisterController::class)->middleware('guest');
    Route::post('organizer/logout', OrganizerLogoutController::class)->middleware('auth:organizer');
});

