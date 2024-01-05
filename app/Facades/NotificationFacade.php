<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

use App\Enums\RusEnums;

class NotificationsFacade extends Facade
{

    function __construct(){
    }

    protected static function getFacadeAccessor()
    {
        return 'response';
    }

}