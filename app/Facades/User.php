<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;

use App\Models\V1\User\User;

class UserFacade extends Facade
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

    protected function getUser($user_id){

        return User::getUser($user_id); 

    }

}