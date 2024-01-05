<?php
namespace App\Providers;
 
use App\Contracts\Wall\WallActionContract;
use App\Actions\V1\Wall\WallAction;

use App\Contracts\Wall\WallAddActionContract;
use App\Actions\V1\Wall\WallAddAction;

use App\Contracts\Wall\WallVoteActionContract;
use App\Actions\V1\Wall\WallVoteAction;

use App\Contracts\Wall\WallVoteCancelActionContract;
use App\Actions\V1\Wall\WallVoteCancelAction;

use App\Contracts\Wall\WallPostActionContract;
use App\Actions\V1\Wall\WallPostAction;

use App\Contracts\Wall\WallUserActionContract;
use App\Actions\V1\Wall\WallUserAction;

use App\Contracts\Wall\WallLikeActionContract;
use App\Actions\V1\Wall\WallLikeAction;

use App\Contracts\Wall\WallLikesListActionContract;
use App\Actions\V1\Wall\WallLikesListAction;

use App\Contracts\Wall\WallVotesListActionContract;
use App\Actions\V1\Wall\WallVotesListAction;

use Illuminate\Support\ServiceProvider;
 
class WallActionsServiceProvider extends ServiceProvider
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

        WallActionContract::class => WallAction::class,
        WallAddActionContract::class => WallAddAction::class,
        WallVoteActionContract::class => WallVoteAction::class,
        WallVotesListActionContract::class => WallVotesListAction::class,
        WallVoteCancelActionContract::class => WallVoteCancelAction::class,
        WallPostActionContract::class => WallPostAction::class,
        WallLikesListActionContract::class => WallLikesListAction::class,
        WallLikeActionContract::class => WallLikeAction::class,
        WallUserActionContract::class => WallUserAction::class,

    ];
}