<?php
namespace App\Services\V1\Users;

use Response;
use Errors;

use App\Services\V1\Wall\WallService;
use App\Services\V1\Data\FamilyService;
use App\Services\V1\Files\DownloadService;
use App\Services\V1\Files\DeleteService;

use App\Models\V1\User\User;

use App\Http\Resources\V1\Users\UserSimpleResource;

class UserStoreService extends UserService{

    private $loader;

    public function __construct(){
        $this->loader = new DownloadService();
    }

    public function deleteAvatar(){
        if ($this->get('profile_photo_path')){
            (new DeleteService())->delete($this->get('profile_photo_path'));
        }
        $this->addProperty('profile_photo_path', '');

        return $this;
    }

    public function uploadAvatar($file){
        $this->addProperty('profile_photo_path', json_encode($this->loader->uploadImage($file, '/users/avatar/'.$this->get('id'))));
        return $this;
    }

}