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
use App\Http\Controllers\Api\EventGenreController;
use App\Http\Controllers\Api\GoogleMapApiController;


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

Route::apiResource('organizers', OrganizerController::class)->except(['create', 'store', 'destroy']);
Route::apiResource('events', EventController::class);
Route::apiResource('organizers.events.articles', ArticleController::class);
Route::apiResource('articles', ArticleController::class)->only(['index', 'show']);

Route::get('/my-events', [EventController::class, 'myEvents']);
Route::get('/event-status/{event}', [EventController::class, 'geteventStatus']);
Route::get('/event-title/{event}', [EventController::class, 'geteventTitle']);
Route::get('/event-image-path/{event}', [EventController::class, 'geteventImagePath']);
Route::get('/events/{event}/date', [EventController::class, 'getEventDate']);
Route::put('/event-status/{event}', [EventController::class, 'updateEventStatus']);
Route::put('/event-title/{event}', [EventController::class, 'updateEventTitle']);
Route::put('/event-image-path/{event}', [EventController::class, 'updateEventImagePath']);
Route::put('/events/{event}/date', [EventController::class, 'updateEventDate']);

Route::apiResource('genres', GenreController::class)->only(['index']);
Route::get('/events/{event}/genres', [EventGenreController::class, 'index']);
Route::put('/event/{event}/genres', [EventGenreController::class, 'update']);

// Route::apiResource('languages', LanguageController::class);

// Route::apiResource('users', UserController::class)->except(['create', 'store', 'destroy']);

Route::get('/get-event-location/{id}', [GoogleMapApiController::class, 'getEventLocation']);
Route::patch('/update-event-location/{id}', [GoogleMapApiController::class, 'updateEventLocation']);
Route::post('/google-maps/search-location', [GoogleMapApiController::class, 'searchLocation']);
Route::get('/get-embed-map-url/{id}', [GoogleMapApiController::class, 'getEmbedMapUrl']);







