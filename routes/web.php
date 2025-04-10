<?php

use App\Http\Controllers\Admin\WriterApprovalController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// FRONTEND ROUTE
Route::get('/', [FrontendController::class, 'home']);
Route::get('/article/{id}', [FrontendController::class, 'details']);
Route::middleware(['auth'])->group(function () {
    Route::post('/like/{id}', [FrontendController::class, 'toggleLike'])->middleware('auth');
});
Route::post('/update-share/{id}', [FrontendController::class, 'updateShare'])->name('articles.share');
// Route untuk kategori dengan ID atau semua artikel

// Route untuk kategori spesifik dengan filter opsional
Route::get('/category/{id}/{filter?}', [FrontendController::class, 'category'])
    ->where('id', '[a-fA-F0-9\-]+')
    ->name('category.show');

// Route untuk semua artikel dengan filter opsional
Route::get('/category/all/{filter?}', [FrontendController::class, 'allArticles'])
    ->name('category.all');

Auth::routes();

// Search
Route::get('/search', [App\Http\Controllers\ArticleController::class, 'search'])->name('articles.search');

// BACKEND ROUTE
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/pending-writers', [WriterApprovalController::class, 'index'])->name('admin.pending-writers');
    Route::post('/approve-writer/{user}', [WriterApprovalController::class, 'approve'])->name('admin.approve-writer');
    Route::post('/reject-writer/{user}', [WriterApprovalController::class, 'reject'])->name('admin.reject-writer');


    Route::get('/writer/dashboard', [App\Http\Controllers\WriterDashboardController::class, 'index'])
        ->name('writer.dashboard')
        ->middleware('role:Writer'); // Menggunakan role Writer

    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('role:Super Admin');

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
        $notification         = Notification::findOrFail($id);
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

    Route::resource('notifications', NotificationController::class);
    Route::delete('/notifications/clear', [NotificationController::class, 'destroy'])->name('notifications.clear');

    Route::get('/profile/activities', [UserController::class, 'getActivities'])->name('profile.activities');

    Route::resource('earning', EarningController::class);

    // withdraw
    Route::get('/withdraws', [App\Http\Controllers\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::get('/withdraws/create', [App\Http\Controllers\WithdrawController::class, 'create'])->name('withdraw.create');
    Route::post('/withdraws', [App\Http\Controllers\WithdrawController::class, 'store'])->name('withdraw.store');
    Route::get('/withdraws/{withdraw}', [App\Http\Controllers\WithdrawController::class, 'show'])->name('withdraw.show');
    Route::put('/withdraws/{withdraw}/cancel', [App\Http\Controllers\WithdrawController::class, 'cancel'])->name('withdraw.cancel');

    // In your web.php or admin routes file
    Route::post('/admin/reject-writer/{user}', [WriterApprovalController::class, 'reject'])->name('admin.reject-writer');

});
