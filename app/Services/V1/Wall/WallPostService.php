<?php
namespace App\Services\V1\Wall;

use Response;
use Errors;

use App\Services\V1\Users\UserService;
use App\Services\V1\Data\FamilyService;
use App\Services\V1\Poll\PollsService;
use App\Services\V1\Comments\CommentsService;

use App\Models\V1\Wall\Wall;
use App\Models\V1\Wall\Follower;
use App\Models\V1\Wall\Link;
use App\Models\V1\Wall\WallBlacklist;
use App\Models\V1\Wall\WallVar;
use App\Models\V1\Wall\WallVarsVote;
use App\Models\V1\Wall\WallMark;
use App\Models\V1\Wall\WallLike;

use App\Http\Resources\V1\Users\UserSimpleResource;

class WallPostService extends WallService{

    public function getPost($post_id){

        if (!$post_id){
            $this->setData((object)[])
                ->setResponse(new Response([], 200));

            return $this;
        }

        $this->checkDataConditions(Wall::getPost($post_id), 'POST_NOT_FOUND');

        return $this;

    }

    /*
        проверяет есть ли доступ к посту
        если отправить любой параметр ложным, то подгрузит данные
        @param int post_id
        @param int user_id
        @return bool
    */
    public function isAccessToPost($post_id = false, $user_id = false){

        $access = false;
        
        if ($user_id){
            $this->setUser($user_id);
        }

        if ($post_id){
            $this->getPost($post_id);
        }

        if ($this->get('user_id') == $this->user->get('id')) return $this;

        if ($this->response()->isFail()){
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('POST_NOT_FOUND')]
            ))->getErrors(), 403));
            return $this;
        }

        if (!$this->user->get('is_access')){
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('HAVE_NOT_PERMISSIONS')]
            ))->getErrors(), 403));
            return $this;
        }

        $permissions = str_split($this->get('permission'));

        $access = false;

        foreach ($permissions as $key => $value) {
            $permission = (int)$value;
            if ($permission > 0 && $permission < 4){
                if ($this->user->get($this->keys[$permission])){
                    $access = true;
                }
            }

            if ($access) break;
        }

        if (!$access){
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('HAVE_NOT_PERMISSIONS')]
            ))->getErrors(), 403));
        }

        return $this;

    }

    public function incrementLikes($post_id){
        $count = WallLike::incrementLikes($post_id, auth()->id());
        $this->addProperty('likes', $count);
        $this->addProperty('is_liked', true);
        return $this;
    }

    public function decrementLikes($post_id){
        $count = WallLike::decrementLikes($post_id, auth()->id());
        $this->addProperty('likes', $count);
        $this->addProperty('is_liked', false);
        return $this;
    }

    public function getLikesList(){

        $this->setData(WallLike::getLikesList($this->get('id')))
                ->setResponse(new Response([], 200));
        
        return $this;
    }

    public function getVotedList(){

        $this->setData(WallVarsVote::getVotedList($this->get('id')))
                ->setResponse(new Response([], 200));
        
        return $this;
    }

}