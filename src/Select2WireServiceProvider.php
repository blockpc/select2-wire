<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire;

use Blockpc\Select2Wire\Console\Select2SingleCommand;
use Blockpc\Select2Wire\Console\Selecte2MulitpleCommand;
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
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                Select2SingleCommand::class,
                Selecte2MulitpleCommand::class,
            ]);
        }
    }
}