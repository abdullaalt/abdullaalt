<?php
namespace App\Services\V1\Files;

use Response;
use Errors;

class DownloadService extends FilesService{

    private $image;

    public function __construct(){
        $this->image = new ImageService();
    }

    public function store($files, $path, $thumbnails = true){

        $result = [];

        foreach($files as $file){
            if (in_array($file->extension(), ['jpg', 'JPG', 'jpeg', 'png', 'gif'])){
                $result[] = $this->uploadImage($file, $path, $thumbnails);
            }
        }

        return $result;

    }

    public function uploadImage($file, $path, $thumbnails = true){
        return $this->image->upload($file, $path, $thumbnails);
    }

}