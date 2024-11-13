<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('categories', CategorieController::class);
    Route::resource('articles', ArticleController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('request', [ArticleController::class, 'request'])->name('request');

    Route::post('/articles/approve/{id}', [ArticleController::class, 'approve'])->name('articles.approve');
    Route::post('/articles/reject/{id}', [ArticleController::class, 'reject'])->name('articles.reject');

    Route::get('/notification/read/{id}', function ($id) {
        $notification = Notification::findOrFail($id);
        $notification->status = 'read'; // Tandai sebagai sudah dibaca
        $notification->save();

        return redirect()->back(); // Kembali ke halaman sebelumnya
    })->name('notification.read');

});
