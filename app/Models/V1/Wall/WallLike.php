<?php
namespace App\Models\V1\Wall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WallLike extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'post_id'];

    public static function isLiked($post_id, $user_id){
        return self::
                where('post_id', $post_id)->
                where('user_id', $user_id)->
				exists();
    }

    public static function incrementLikes($post_id, $user_id){

        self::create([
            'post_id' => $post_id,
            'user_id' => $user_id
        ]);

        return self::where('post_id', $post_id)->count();
    }

    public static function decrementLikes($post_id, $user_id){
        self::where('post_id', $post_id)
            ->where('user_id', $user_id)
            ->delete();

        return self::where('post_id', $post_id)->count();
    } 
    
    public static function getLikesList($post_id){
        return self::where('post_id', $post_id)
                    ->leftJoin('users as u', 'u.id', '=', 'wall_likes.user_id')
                    ->select('u.id', 'u.username', 'u.nickname', 'u.profile_photo_path')
                    ->paginate(20);
    }

}