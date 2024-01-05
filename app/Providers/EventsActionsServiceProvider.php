<?php
namespace App\Providers;

use App\Contracts\Events\EventsActionContract;
use App\Actions\V1\Events\EventsAction;

use App\Contracts\Events\EventsItemActionContract;
use App\Actions\V1\Events\EventsItemAction;

use Illuminate\Support\ServiceProvider;

class EventsActionsServiceProvider extends ServiceProvider
{
    /** 
     * Bootstrap the application services. 
     * 
     * @return void 
     */
    public function boot()
    {
        // 
    }

    /** 
     * Register the application services. 
     * 
     * @return void 
     */
    public array $bindings = [

        EventsActionContract::class => EventsAction::class,
        EventsItemActionContract::class => EventsItemAction::class,

    ];
}