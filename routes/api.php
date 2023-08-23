<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ArticleTranslationController;
use App\Http\Controllers\Api\ArticleImageController;
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

Route::apiResource(
    'articles',
    ArticleController::class
);

Route::apiResource(
    'articles.translations',
    ArticleTranslationController::class
)->only(['index', 'store', 'show']);

Route::apiResource(
    'genres',
    GenreController::class
)->only(['index', 'show']);

Route::apiResource(
    'languages',
    LanguageController::class
)->only(['index', 'show']);

Route::apiResource(
    'articles.images',
    ArticleImageController::class
)->only(['index', 'store', 'show']);





