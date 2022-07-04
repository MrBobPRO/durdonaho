<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Quote;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.app', 'dashboard.layouts.app'], function ($view) {
            $view->with('route', Route::currentRouteName());
        });

        View::composer(['components.aside-categories'], function ($view) {
            $view->with('categories', Category::approved()->orderBy('title')->get());
        });

        View::composer(['components.aside-popular-categories'], function ($view) {
            $view->with('categories', Category::where('popular', true)->approved()->inRandomOrder()->get());
        });

        View::composer(['components.aside-popularity'], function ($view) {
            $view->with('quote', Quote::where('popular', true)->approved()->inRandomOrder()->first())
                ->with('author', Author::where('popular', true)->approved()->inRandomOrder()->first());
        });

        View::composer(['components.filter-categories'], function ($view) {
            $view->with('categories', Category::approved()->orderBy('title')->get());
        });

        View::composer(['dashboard.layouts.aside', 'dashboard.layouts.new-quote-notification'], function ($view) {
            $view->with('unverifiedQuotesCount', Quote::where('verified', false)->count());
        });
    }
}
