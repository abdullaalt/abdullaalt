<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ExceptionHandler;

class ErrorsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('errors', function ($app) {
            return $app->make(ExceptionHandler::class);
        });
    }
}