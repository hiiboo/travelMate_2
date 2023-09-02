<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\OrganizerLoginController;
use \App\Http\Controllers\Auth\OrganizerRegisterController;
use \App\Http\Controllers\Auth\OrganizerLogoutController;
use \App\Http\Controllers\Auth\UserLoginController;
use \App\Http\Controllers\Auth\UserRegisterController;
use \App\Http\Controllers\Auth\UserLogoutController;

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
    Route::post('user/login', UserLoginController::class)->middleware('guest');
    Route::post('user/register', UserRegisterController::class)->middleware('guest');
    Route::post('user/logout', UserLogoutController::class)->middleware('auth:sanctum');

    // Organizer Routes
    Route::post('organizer/login', OrganizerLoginController::class)->middleware('guest');
    Route::post('organizer/register', OrganizerRegisterController::class)->middleware('guest');
    Route::post('organizer/logout', OrganizerLogoutController::class)->middleware('auth:organizer');
});

// api.phpからweb.phpに移動したからfrontの const response = await axios.get(`${apiUrl}/organizer/api/check-auth`, を const response = await axios.get(`${apiUrl}/organizer/check-auth`に変更を忘れずに。あとRoute::middleware('auth:sanctum')ならつまりuser loginならresponse = await axios.get(`${apiUrl}/check-auth`に変更する
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check-auth', function () {
        return response()->json(['isLoggedIn' => true]);
    });
});

Route::middleware('auth:organizer')->group(function () {
    Route::get('organizer/check-auth', function () {
        return response()->json(['isLoggedIn' => true]);
    });
});

