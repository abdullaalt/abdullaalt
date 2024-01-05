<?php
namespace App\Services\V1\Media;

use Response;
use Errors;

class MediaViewService{

    private $data = [];

    /*
        заполняет массив медиа файлами
        исходя из типа, вызывает нужную функцию
        @param object media
        @return this
    */
    public function preparingMedia($media){
        
        foreach ($media as $key => $value) {
            if ($value->type == 'image'){
                $this->addToData($this->getImageObject($value));
            }
        }

        return $this;

    }

    public function get(){
        return $this->data;
    }

    public function getImageObject($image){

        return (object)[
                'type'=>'image',
                'link'=>print_image_src($image, 'original'),
                'sizes' => [
                    'original'=>print_image_src($image, 'original'),
                    'medium' => print_image_src($image, 'medium'),
                    'small' => print_image_src($image, 'small'),
                ]
            ];

    }

    public function addToData($data){

        $this->data[] = $data;

    }

}