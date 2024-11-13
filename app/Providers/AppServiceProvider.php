<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('backend.header', function ($view) {
            $notifications = auth()->check()
            ? auth()->user()->notifications()->orderBy('created_at', 'desc')->take(10)->get()
            : collect(); // Jika user belum login, beri koleksi kosong

            $unreadCount = auth()->check()
            ? auth()->user()->notifications()->where('status', 'unread')->count()
            : 0;

            $view->with(compact('notifications', 'unreadCount'));
        });
    }
}
