<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;

use App\Models\V1\Data\Data;
use App\Models\V1\Data\Link;

class DataFacade extends MainFacade
{

    protected static function getFacadeAccessor()
    {
        return 'data';
    }

    protected function loadNode($node_id){
        return Data::find($node_id);
    }

    protected function loadLinks($node_id){
        return Link::find($node_id);
    }

    protected function getChilds($node_id){
        return Link::getChilds($node_id);
    }

    protected function getSiblings($f_id, $m_id){
        return Link::getSiblings($f_id, $m_id);
    }
    
}