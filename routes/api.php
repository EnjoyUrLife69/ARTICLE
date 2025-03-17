<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('articles/{id}/like', [App\Http\Controllers\API\LikeController::class, 'toggleLike']);
    Route::get('articles/{id}/check-like', [App\Http\Controllers\API\LikeController::class, 'checkLikeStatus']);
});

// ARTICLE ROUTE
Route::get('/articles', [ArticleController::class, 'index']);           // Get all articles
Route::get('/articles/{id}', [ArticleController::class, 'show']);       // Get single article
Route::post('/articles', [ArticleController::class, 'store']);          // Create new article
Route::put('/articles/{id}', [ArticleController::class, 'update']);     // Update article
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']); // Delete article
 