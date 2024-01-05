<?php
namespace App\Services\V1\Wall;

use Response;
use Errors;

use App\Facades\Wall\WallFacade;

use App\Services\V1\Users\UserService;
use App\Services\V1\Data\FamilyService;
use App\Services\V1\Poll\PollsService;
use App\Services\V1\Comments\CommentsService;
use App\Services\V1\Marks\MarksService;

use App\Models\V1\Wall\Wall;
use App\Models\V1\Wall\Follower;
use App\Models\V1\Wall\Link;
use App\Models\V1\Wall\WallBlacklist;
use App\Models\V1\Wall\WallVar;
use App\Models\V1\Wall\WallMark;
use App\Models\V1\Wall\WallLike;

use App\Http\Resources\V1\Users\UserSimpleResource;

class WallService extends WallFacade{

    protected $wall;
    protected $user;
    protected $poll = false;
    protected $comment = false;

    public $keys = [
        3 => 'is_in_teip',
        2 => 'is_follow',
        1 => 'is_in_family'
    ];

    protected $permissions = [
		'all'=>'4',
		'teip' => '3',
		'followers' => '2',
		'family' => '1'
	];

    public function __construct(){
        $this->wall = new Wall();
        $this->wall->setDescriptor();
        $this->poll = new PollsService();
        $this->comment = new CommentsService();

        //$this->user = new UserService();
        //$this->user->getUser(auth()->id());
    }

    public function getWall($filter = false, $user_id = false){

        if ($user_id){
            $this->setUser($user_id);

            if ($this->user->response()->isFail()){
                $this->setResponse(new Response($this->user->response()->getData(), $this->user->response()->getCode()));

                return $this;
            }
            
            if (!$this->user->get('is_access')){
                $this->setResponse(new Response((new Errors(
                    [Response::getLangValue('HAVE_NOT_PERMISSIONS')]
                ))->getErrors(), 403));

                return $this;
            }

            $this->wall
                ->setUser($this->user)
                ->setUserFilters();
        }else{

            if ($filter == 'followers' || !$filter){
                $this->wall
                    ->setSubs(Follower::getSubs(auth()->id()))
                    ->setFollowersFilter();
            }

            if ($filter == 'teip' || !$filter){
                $this->wall
                    ->setTeipFilter();
            }

            if ($filter == 'family' || !$filter){
                if (auth()->user()->tree_number > 0){
                    $this->wall
                        ->setFamily(
                                        (new FamilyService())->buildFamily(auth()->user()->tree_number)
                                                            ->getFamilyPersons()
                                    )
                        ->setFamilyFilter();
                }
            }

            $this->wall->setOrUserFilters();

        }

        $this->wall
            ->setBlackList(WallBlacklist::getBlacklist(auth()->id()))
            ->setBlacklistFilter();

        $this->setData($this->wall->get());
        $this->setResponse(new Response([], 200));

        return $this;

    }

    public function preparingSingleResult(){
        if (!$this->response()->isFail()){
            $this->setData($this->preparingSinglePost($this->get()));
        }

        return $this;
    }

    public function preparingResult($posts = false){

        if ($this->response()->isFail()){
            return $this;
        }

        $posts = $posts ? $posts->items() : $this->get()->items();
        $result = [];

        foreach ($posts as $key=>$post){

            $result[] = $this->preparingSinglePost($post);

        }
        
        $this->setData((object)$result);

        return $this;

    }

    public function preparingSinglePost($post){

        if (!$this->poll){
            $this->poll = new PollService();
        }

        if (!$this->comment){
            $this->comment = new CommentsService();
        }

        $post->vote_info = $this->poll->getPoll($post->id);
        $post->marked_users = $this->getPostMarks($post->id);
        $post->comment = $this->comment->getMostLikedComment('post', $post->id);
        if (!$post->comment->response()->isFail()){
             $post->comment->addProperty('is_liked', $this->comment->isLikedComment($post->comment->get('id')));
        }
        $post->comment = $post->comment->get();
        $post->is_liked = $this->isPostLiked($post->id, auth()->id());
        //$post->media = $this->media->preparingMedia($post->media);

        return $post;
    }

    public function isPostLiked($post_id, $user_id){
        return WallLike::isLiked($post_id, $user_id);
    }

    public function getPostMarks($post_id){

        $marks = WallMark::getPostMarks($post_id);

        if (count($marks) < 1)
            return null;

        // $result = [];
        // foreach ($marks as $item){
        //     if (!$item->node_id) continue;
        //     $item->avatar = print_image_src(@$item->avatar, 'medium');
        //     $item->username = null;
        //     $item->user_id = $item->user_id;
        //     $item->node_id = $item->node_id;
        //         //unset($item->profile_photo_path);
        //     $result[] = $item;
        // }

        return $marks;

    }

    public function isFollower($who, $on_whom){ //кто на ком подписан

        return Follower::isFollower($who, $on_whom);

    }

    public function isMyFollower($user_id){
        return $this->isFollower($user_id, auth()->id);
    }

    public function setUser($user_id){

        $this->user = new UserService();
        $this->user->getUser($user_id);
        return $this;

    }

    public function saveData($array = false){

        $this->save(Wall::class, $array);

    }

    public function getPermissionString($permissions){

        $permission = '';

        foreach ($this->permissions as $key => $value) {
			if (array_search($key, $permissions) !== false) {$permission .= $value;}
			else $permission .= '0';
		}

        return $permission;

    }

}