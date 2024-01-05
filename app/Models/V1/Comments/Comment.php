<?php
namespace App\Models\V1\Comments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\NotificationsController;

class Comment extends Model{

    public $timestamps = true;
	
	protected $fillable = ['user_id', 'source', 'source_id', 'text', 'parent_id', 'root_parent', 'likes'];

    public static function getCommentByRules($source, $source_id, $order_by = 'id', $order_to = 'DESC'){

        return self::where('comments.source', $source)
                    ->where('comments.source_id', $source_id)
                    ->leftJoin('users as u', 'u.id', '=', 'comments.user_id')
                    ->orderBy('comments.'.$order_by, $order_to)
                    ->select('comments.*', 'u.nickname', 'u.username', 'u.profile_photo_path')
                    ->first();

    }

    public static function getList($source_id, $source, $parent_id = 0, $order_by = 'id', $order_to = 'DESC'){
       
        return self::where('source', $source)
                ->where('source_id', $source_id)
                ->where('root_parent', $parent_id)
                ->exists() ? 
                self::where('comments.source', $source)
                            ->where('comments.source_id', $source_id)
                            ->where('comments.root_parent', $parent_id)
                            ->leftJoin('users as u', 'u.id', '=', 'comments.user_id')
                            ->orderBy('comments.'.$order_by, $order_to)
                            ->select('comments.*', 'u.nickname', 'u.username', 'u.profile_photo_path')
                            ->paginate(20)
                :
                false;

    }

    public static function getComment($comment_id){
        return self::where('comments.id', $comment_id)
                ->exists() ? 
                (object)self::where('comments.id', $comment_id)
                            ->leftJoin('users as u', 'u.id', '=', 'comments.user_id')
                            ->select('comments.*', 'u.nickname', 'u.username', 'u.profile_photo_path')
                            ->first()->toArray()
                :
                false;
    }

    public static function getCommentChildsCount($comment_id){
        return self::where('root_parent', $comment_id)->count();
    }

}