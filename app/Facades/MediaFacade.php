<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;
use Errors;

use App\Services\V1\Media\MediaViewService;

class MediaFacade extends MainFacade
{

    public $mediaView;

    public function __construct(){
        $this->mediaView = new MediaViewService();
    }

}