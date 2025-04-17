<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\API\DisqusController;

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

// routes/api.php
Route::post('/update-share/{articleId}', [ArticleController::class, 'updateShareCount']);

// ARTICLE ROUTE
Route::get('/articles', [ArticleController::class, 'index']);           // Get all articles
Route::get('/articles/{id}', [ArticleController::class, 'show']);       // Get single article
Route::post('/articles', [ArticleController::class, 'store']);          // Create new article
Route::put('/articles/{id}', [ArticleController::class, 'update']);     // Update article
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']); // Delete article
 
// API routes untuk Disqus
Route::prefix('disqus')->group(function () {
    Route::get('comments/{threadId}', [DisqusController::class, 'getComments']);
    Route::get('thread/{identifier}', [DisqusController::class, 'getThread']);
    Route::post('comment', [DisqusController::class, 'createComment']);
});


Route::get('storage/images/articles/{path}', function ($path) {
    $path = storage_path('app/public/' . $path);
    if (! File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = response($file, 200);
    $response->header("Content-Type", $type);
    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Access-Control-Allow-Methods', 'GET, HEAD');

    return $response;
})->where('path', '.*');


// routes/api.php
Route::get('/storage/images/articles/{filename}', function ($filename) {
    $path = storage_path('app/public/images/articles/' . $filename);

    if (! file_exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    $file = file_get_contents($path);
    $type = function_exists('mime_content_type') ? mime_content_type($path) : 'image/jpeg';

    return response($file)
        ->header('Content-Type', $type)
        ->header('Access-Control-Allow-Origin', '*');
});





