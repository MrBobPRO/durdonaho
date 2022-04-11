<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Quote;
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
        View::composer(["layouts.app", "dashboard.layouts.app"], function ($view) {
            $view->with('route', Route::currentRouteName());
        });

        View::composer(["components.aside-categories"], function ($view) {
            $view->with('categories', Category::orderBy('title')->get());
        });

        View::composer(["components.aside-popular-categories"], function ($view) {
            $view->with('categories', Category::where('popular', true)->inRandomOrder()->get());
        });

        View::composer(["components.aside-popularity"], function ($view) {
            $view->with('quote', Quote::where('popular', true)->inRandomOrder()->first())
                ->with('author', Author::where('popular', true)->inRandomOrder()->first());
        });

        View::composer(["components.filter-categories"], function ($view) {
            $view->with('categories', Category::orderBy('title')->get());
        });
    }
}
