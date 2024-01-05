<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Services\V1\Notifications\NotificationsService;
class NotificationsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('notifications', function ($app) {
            return new NotificationsService();
        });
    }
}