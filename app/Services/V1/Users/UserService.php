<?php
namespace App\Services\V1\Users;

use Response;
use Errors;

use App\Facades\UserFacade;

use App\Services\V1\Wall\WallService;
use App\Services\V1\Data\FamilyService;
use App\Models\V1\User\User;
use App\Http\Resources\V1\Users\UserSimpleResource;

class UserService extends UserFacade{

    private $wall;

    public function __construct(){
        
        $this->wall = new WallService();
        
    }

    public function saveData($array = false){

        $this->save(User::class, $array);

    }

    public function getUser($user_id, $with_props = true){

        $this->user_id = $user_id;
        $data = parent::loadUser($user_id);

        if ($data){
            $this->setData($data);
            $this->setResponse(new Response([], 200));
            if ($with_props){
                $this->addProperty('is_follow', $this->wall->isFollower(auth()->id(), $user_id));
                $this->addProperty('is_in_teip', auth()->user()->teip == $this->get('teip'));
                $this->addProperty('is_in_family', $this->isUserInFamily(auth()->user()->tree_number, $this->get('tree_number')));
                $this->addProperty('is_access', $this->isUserPageAccess($user_id));
            }
        }else{
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('USER_NOT_FOUND')]
            ))->getErrors(), 404));
        }

        return $this;

    }

    public function isUserInFamily($node_id1, $node_id2){
        return (new FamilyService())->isInFamily($node_id1, $node_id2);
    }

    public function isUserBlocked($user_id = false){
        $user_id = $user_id ? $user_id : $this->user_id;
        return $this->isBlocked($user_id);
    }

    public function isUserPageAccess($user_id = false){
        $user_id = $user_id ? (int)$user_id : (int)$this->user_id;

        $access = false;

        if (auth()->id() == $user_id || $this->get('is_open') || $this->wall->isFollower(auth()->id(), $user_id)){
            $access = true;
        }

        // if (!$access && $this->get('teip_item')){
        //     if (){
                
        //     }else{

        //     }
        // }else if (!$access && !$this->get('teip_item')){
        //     $access = false;
        // }

        return $access;
    }

    // public function save($data, $user_id = false){
    //     return true;
    // }

    public function checkCondition($user_id){
        if ($user_id < 1){
            return false;
        }

        return true;
    }

    public function loadDataForForeight($user_id){
        if (!$this->checkCondition($user_id)){
            return [];
        }

        return $this->getUser($user_id)->get();
    }

}