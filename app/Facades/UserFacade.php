<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;
use Errors;


use App\Models\V1\User\User;
use App\Models\V1\User\UsersBlocked;
use App\Models\V1\User\UsersGroupsMember;

class UserFacade extends MainFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'user';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     *
     * @throws \RuntimeException
     */

    public static function loadUser($user_id){

        $user = User::getUser($user_id);
        
        return $user;

    }

    protected function isBlocked($user_id){
        return UsersBlocked::isBlocked($user_id);
    }

    protected function isAccess($user_id){

        $access = true;

    }

    

}