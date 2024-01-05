<?php
namespace App\Services\V1\Files;

use Response;
use Errors;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Services\V1\Media\MediaService;

class DeleteService extends FilesService{

    public function delete($media){

        if (is_string($media)){
            $media = json_decode($media);
        }

        foreach ($media as $key => $value) {

            if ($key == 'type') continue;

            if (Storage::exists($value)) {
                Storage::delete($value);
            }

        }

    }

}