<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('response', function ($app) {
            return $app->make(ResponseFactory::class);
        });
    }
}