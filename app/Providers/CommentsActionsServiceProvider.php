<?php
namespace App\Providers;

use App\Contracts\Comments\CommentsActionContract;
use App\Actions\V1\Comments\CommentsAction;

use App\Contracts\Comments\CommentsSubActionContract;
use App\Actions\V1\Comments\CommentsSubAction;

use App\Contracts\Comments\CommentsAddActionContract;
use App\Actions\V1\Comments\CommentsAddAction;

use App\Contracts\Comments\CommentsDeleteActionContract;
use App\Actions\V1\Comments\CommentsDeleteAction;




use Illuminate\Support\ServiceProvider;

class CommentsActionsServiceProvider extends ServiceProvider
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

        CommentsActionContract::class => CommentsAction::class,
        CommentsSubActionContract::class => CommentsSubAction::class,
        CommentsAddActionContract::class => CommentsAddAction::class,
        CommentsDeleteActionContract::class => CommentsDeleteAction::class,

    ];
}