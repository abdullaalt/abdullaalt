<?php
namespace App\Providers;
 
use App\Contracts\Users\UserActionContract;
use App\Actions\V1\Users\UserAction;

use App\Contracts\Users\UserInfoActionContract;
use App\Actions\V1\Users\UserInfoAction;

use Illuminate\Support\ServiceProvider;
 
class UsersActionsServiceProvider extends ServiceProvider
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

        UserActionContract::class => UserAction::class,
        UserInfoActionContract::class => UserInfoAction::class

    ];
}