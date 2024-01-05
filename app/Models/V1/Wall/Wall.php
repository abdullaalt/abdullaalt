<?php
namespace App\Models\V1\Wall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wall extends Model{

    /*
        4 для всех
        3 для тейпа
        2 для подписчиков
        1 для семьи
    */
    use HasFactory;
	public $timestamps = true;
	
	protected $fillable = ['user_id', 'pubdate', 'media', 'text', 'views', 'comments_count', 'tags', 'permission', 'likes', 'proportions', 'comments_on'];

    protected $table = 'wall';

    private $filter = false;
    private $user = false;
    private $subs = false;
    private $blacklist = false;
    private $family = false;
    private $descriptor = false;

    public function setDescriptor(){
        $this->descriptor = self::leftJoin('users', 'wall.user_id', '=', 'users.id')->
                select('wall.*', 'users.profile_photo_path as avatar', 'users.nickname', 'users.username')->
                orderBy('pubdate', 'desc');
    }

    public static function addPost($post){
        
        return self::create($post);

    }

    public function descriptor(){
        
        return $this->descriptor;

    }

    public static function getPost($post_id){
        return self::where('wall.id', $post_id)
                    ->leftJoin('users', 'wall.user_id', '=', 'users.id')
                    ->select('wall.*', 'users.profile_photo_path as avatar', 'users.nickname', 'users.username')
                    ->first();
    }

    public function get(){

        return $this->descriptor->paginate(20);

    }

    /*

    */
    public function setUserFilters(){
        $this->descriptor->where('wall.user_id', $this->user->get('id'));
        $this->descriptor->where(function($query){
            if ($this->user->get('is_follow')){
                $query->orWhere('wall.permission', 'like', '__2_');
            }

            if ($this->user->get('is_in_teip')){
                $query->orWhere('wall.permission', 'like', '_3__');
            }

            if ($this->user->get('is_in_family')){
                $query->orWhere('wall.permission', 'like', '___1');
            }

            $query->orWhere('wall.permission', 'like', '4___');
        });
    }

    public function setOrUserFilters(){
        $this->descriptor->orWhere('wall.user_id', auth()->id());

        $this->descriptor->orWhere(function($q){
            $q->where('wall.permission', 'like', '4___')
                ->where('users.is_open', 1);
        });
    }

    public function setTeipFilter(){

        $this->descriptor->orWhere(function($q){
            $q->where('wall.permission', 'like', '_3__')->
            where('users.is_open', 1);
        });

    }

    public function setFamilyFilter(){

        if (!$this->family){
            return true;
        }

        $ids = [];

        foreach ($this->family as $key => $node) {
            $ids[] = $node->user_id;
        }

        $this->descriptor->orWhere(function($q) use ($ids){
					
            $q->where('wall.permission', 'like', '___1');
            $q->whereIn('wall.user_id', $ids);
            
        });

    }

    public function setFollowersFilter(){

        if (!$this->subs){
            return true;
        }

        $ids = [];

        foreach ($this->subs as $key => $sub) {
            $ids[] = $sub->subs_id;
        }

        $this->descriptor->orWhere(function($q) use ($ids){
					
            $q->where('wall.permission', 'like', '__2_');
            $q->whereIn('wall.user_id', $ids);
            
        });

    }

    public function setBlacklistFilter(){

        if (!$this->blacklist){
            return true;
        }

        $ids = [];

        foreach ($this->blacklist as $key => $item) {
            $ids[] = $item->post_id;
        }

        $this->descriptor->where(function($q) use ($ids){
					
            $q->where('wall.permission', 'like', '__2_');
            $q->whereNotIn('wall.id', $ids);
            
        });

    }

    public function setFamily($family){
        $this->family = $family;
        return $this;
    }

    public function setUser($user){
        $this->user = $user;
        return $this;
    }

    public function setSubs($subs){
        $this->subs = $subs;
        return $this;
    }

    public function setFilter($filter){
        $this->filter = $filter;
        return $this;
    }

    public function setBlackList($list){
        $this->blacklist = $list;
        return $this;
    }

}