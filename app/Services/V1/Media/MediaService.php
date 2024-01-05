<?php
namespace App\Services\V1\Media;

use Response;
use Errors;

use App\Facades\MediaFacade;

class MediaService extends MediaFacade{

    public function preparingMedia($media){

        if (is_string($media)){
            $media = json_decode($media);
        }

        return $this->mediaView->preparingMedia($media)->get();

    }

}