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
    public function boot(): void
    {
        View::composer('backend.header', function ($view) {
            if (auth()->check()) {
                $notifications = auth()->user()
                    ->notifications()
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

                $unreadCount = auth()->user()
                    ->notifications()
                    ->where('status', false)
                    ->count();

            } else {
                $notifications = collect(); // Koleksi kosong jika belum login
                $unreadCount   = 0;
            }

            $view->with(compact('notifications', 'unreadCount'));
        });
    }
}
