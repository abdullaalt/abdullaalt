<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;

class SettingsFacade extends MainFacade
{

    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
    
}