<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Cart;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('site.partials.nav', function($view){
            $view->with('cart', Cart::content());
        });

        view()->composer('site.pages.index', function($view){
            $view->with('cart', Cart::content());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
