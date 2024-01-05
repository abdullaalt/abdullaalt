<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;

use App\Models\V1\Data\Tree;

class TeipFacade extends MainFacade
{

    protected static function getFacadeAccessor()
    {
        return 'data';
    }

    protected function loadTeip($teip_id){
        return Tree::find($teip_id);
    }
    
}