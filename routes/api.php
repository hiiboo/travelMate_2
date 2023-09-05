<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ArticleTranslationController;
use App\Http\Controllers\Api\ArticleImageController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:organizer-api')->get('/organizer', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/check-auth', function () {
//         return response()->json(['isLoggedIn' => true]);
//     });
// });

// Route::middleware('auth:organizer')->group(function () {
//     Route::get('organizer/check-auth', function () {
//         return response()->json(['isLoggedIn' => true]);
//     });
// });

Route::apiResource('organizers', OrganizerController::class)->except(['create', 'store', 'destroy']);
Route::apiResource('organizers.events', EventController::class);
Route::apiResource('organizers.events.articles', ArticleController::class);

Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('articles', ArticleController::class)->only(['index', 'show']);



// Route::apiResource('genres', GenreController::class);
// Route::apiResource('languages', LanguageController::class);

// Route::apiResource('users', UserController::class)->except(['create', 'store', 'destroy']);

Route::get('/get-event-location/{id}', 'GoogleMapApiController@getEventLocation');
Route::patch('/update-event-location/{id}', 'GoogleMapApiController@updateEventLocation');
Route::post('/google-maps/search-location', 'GoogleMapApiController@searchLocation');
Route::get('/get-embed-map-url/{id}', 'GoogleMapApiController@getEmbedMapUrl');







