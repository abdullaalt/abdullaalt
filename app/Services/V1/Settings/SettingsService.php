<?php
namespace App\Services\V1\Settings;

use Response;
use Errors;

use App\Facades\SettingsFacade;

use App\Services\V1\Users\UserStoreService;
use App\Services\V1\Users\UserPermissionsService;
use App\Services\V1\Permissions\PermissionsService;

class SettingsService extends SettingsFacade
{

    private $user;
    private $permissions;

    public function __construct($user_id = false){
        $user_id = !$user_id ? auth()->id() : $user_id;
        $this->user = new UserStoreService();
        $this->permissions = new PermissionsService(UserPermissionsService::class);
        $this->user->getUser($user_id, false);
    }

    public function user(){
        return $this->user;
    }

    public function permissions(){
        return $this->permissions;
    }

}