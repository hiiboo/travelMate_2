<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ArticleTranslationController;
use App\Http\Controllers\Api\ArticleImageController;
use App\Http\Controllers\Api\OrganizerController;
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

Route::apiResource('organizers', OrganizerController::class)->except(['create', 'store', 'destroy']);
Route::apiResource('organizers.articles', ArticleController::class);
Route::apiResource('organizers.articles.translations', ArticleTranslationController::class)->only(['index', 'show', 'store']);
Route::apiResource('organizers.articles.images', ArticleImageController::class)->only(['index', 'show', 'store']);
// Route::apiResource('articles', ArticleController::class)->only(['index', 'show']);
// Route::apiResource('articles.translations', ArticleTranslationController::class)->only(['index', 'show']);
// Route::apiResource('articles.images', ArticleImageController::class)->only(['index', 'show']);  
Route::apiResource('genres', GenreController::class);
Route::apiResource('languages', LanguageController::class);

// Route::apiResource('users', UserController::class)->except(['create', 'store', 'destroy']);





