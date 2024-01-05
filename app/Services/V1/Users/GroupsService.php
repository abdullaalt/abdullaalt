<?php
namespace App\Services\V1\Users;

use Response;
use Errors;

use App\Facades\UserFacade;

use App\Services\V1\Wall\WallService;
use App\Models\V1\User\UsersGroup;
use App\Models\V1\User\UsersGroupsMember;

use App\Http\Resources\V1\Users\UserSimpleResource;

class GroupsService extends UserFacade{

    public function getGroup($value_id, $by = 'group_id'){ // $by = user_id|group_id

        if ($by == 'user_id'){
            $value_id = $this->getUserGroupId($value_id);
        }

        $data = UsersGroup::getGroup($value_id);

        if ($data){
            $this->setData($data);
            $this->setResponse(new Response([], 200));
        }else{//dd(Response::getLangValue('USER_NOT_FOUND')->value);
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('GROUP_NOT_FOUND')]
            ))->getErrors(), 404));
        }

        return $this;

    }

    public function getUserGroupId($user_id){
        return UsersGroupsMember::getUserGroup($user_id)->group_id;
    }

    public function checkCondition($group_id){
        if (!$group_id){
            return false;
        }

        return true;
    }

    public function loadDataForForeight($group_id){
        if (!$this->checkCondition($group_id)){
            return [];
        }

        return $this->getGroup($group_id)->get();
    }

}