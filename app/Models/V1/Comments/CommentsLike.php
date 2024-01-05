<?php
namespace App\Models\V1\Comments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\NotificationsController;

class CommentsLike extends Model{

    public $timestamps = true;
	
	protected $fillable = ['comment_id', 'user_id'];

    public static function isLikedComment($comment_id){

        return self::where('comment_id', $comment_id)
                    ->where('user_id', auth()->id())
                    ->exists();

    }

    public static function deleteLikes($comment_id){
        self::where('comment_id', $comment_id)->delete();
    }

}