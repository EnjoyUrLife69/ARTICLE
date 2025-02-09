<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Article;

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

            $view->with('newArticlesCount', $newArticlesCount);
        });
    }

}
