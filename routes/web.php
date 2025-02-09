<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// FRONTEND ROUTE
Route::get('/', [FrontendController::class, 'home']);
Route::get('/article/{id}', [FrontendController::class, 'details']);

Auth::routes();

// BACKEND ROUTE
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('categories', CategorieController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/all-articles', [ArticleController::class, 'allArticles'])->name('articles.all'); // Semua artikel

    Route::post('/comments', [CommentController::class, 'create'])->name('comments.store');

    Route::resource('users', UserController::class);
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update-image/{id}', [UserController::class, 'updateImage'])->name('profile.updateImage');

    Route::get('request', [ArticleController::class, 'request'])->name('request');
    Route::post('/articles/approve/{id}', [ArticleController::class, 'approve'])->name('articles.approve');
    Route::put('/articles/{id}/reject', [ArticleController::class, 'reject'])->name('articles.reject');

    Route::get('/notification/read/{id}', function ($id) {
        $notification = Notification::findOrFail($id);
        $notification->status = 'read'; // Tandai sebagai sudah dibaca
        $notification->save();

        return redirect()->back(); // Kembali ke halaman sebelumnya
    })->name('notification.read');

    Route::post('/notifications/mark-as-read', function () {
        $user = auth()->user();
        if ($user) {
            $user->notifications()->where('status', false)->update(['status' => true]);
        }

        return response()->json(['success' => true]);
    })->name('notifications.markAsRead');

    Route::resource('notifications' , NotificationController::class);
    Route::delete('/notifications/clear', [NotificationController::class, 'destroy'])->name('notifications.clear');

    Route::get('/profile/activities', [UserController::class, 'getActivities'])->name('profile.activities');

});
