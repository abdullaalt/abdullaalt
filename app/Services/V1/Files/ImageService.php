<?php
namespace App\Services\V1\Files;

use Response;
use Errors;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ImageService extends FilesService{

    private $sizes = [
        'small' => [100, 100],
        'medium' => [580, 350],
        'original' => [1280, 760],
    ];

    public function upload($file, $path, $thumbnails = true){

        $result = [];
        $result['type'] = 'image';
        foreach ($this->sizes as $key => $value) {
            $result[$key] = $this->uploadSize($file, $path, $key);
        }

        return $result;
        
    }

    public function uploadSize($file, $path, $size){

        $filenamewithextension = $file->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $image = $file->storePubliclyAs($path.'/thumbnail', md5($filename.'small').'.'.$extension);
		$thumbnailpath = storage_path('app/'.$image);
		$thumbnail = Image::make($thumbnailpath)->orientate()->resize($this->sizes[$size][0], $this->sizes[$size][1], function($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});
		$thumbnail->save($thumbnailpath);

        return $image;

    }

}