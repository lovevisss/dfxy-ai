<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::share('title', env('APP_NAME'));
        View::composer('welcome', function ($view) {
            $view->with('posts', Post::all());
        });
        View::composer(['ai.index', 'ai.create', 'ai.edit'], function ($view) {
            if (! array_key_exists('tags', $view->getData())) {
                $view->with('tags', Tag::all());
            }
        });
    }
}
