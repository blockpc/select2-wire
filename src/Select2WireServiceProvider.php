<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire;

use Illuminate\Support\ServiceProvider;

final class Select2WireServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('select2', function () {
            return new Select2;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}