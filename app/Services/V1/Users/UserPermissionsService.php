<?php
namespace App\Services\V1\Users;

use Response;
use Errors;

use App\Services\V1\Users\UserService;

class UserPermissionsService extends UserService
{

        public function havePermissions($action, $user_id)
        {
                return call_user_func([$this, $action], $user_id);
        }

        private function edit($user_id)
        {
                return auth()->id() == $user_id || auth()->user()->is_admin;
        }

}