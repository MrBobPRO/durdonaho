<?php

namespace App\Providers;

use App\Models\Category;
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
    }
}
