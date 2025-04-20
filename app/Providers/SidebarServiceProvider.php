<?php
namespace App\Providers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $newArticlesCount = Article::where('status', 'pending')
                ->count();
            $pendingWritersCount = User::role('Pending Writer')->count();

            $view->with('newArticlesCount', $newArticlesCount)
                ->with('pendingWritersCount', $pendingWritersCount);
        });
    }

}
