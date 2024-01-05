<?php
namespace App\Models\V1\Wall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\NotificationsController;

class WallMark extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'post_id', 'node_id', 'left_pos', 'top_pos', 'media_index'];

    public static function getPostMarks($post_id){
        return self::
				leftJoin('data', 'wall_marks.node_id', '=', 'data.id')->
				leftJoin('users', 'data.user_id', '=', 'users.id')->
				where('post_id', $post_id)->
				select('wall_marks.id as mark_id', 'wall_marks.media_index', 'wall_marks.top_pos', 'wall_marks.left_pos', 'data.id as node_id', 'data.user_id as user_id', 'data.fio as nickname', 'users.profile_photo_path as avatar')->
				get();
    }

	public static function addMark($item){
		self::create($item);
	}

	public static function deleteMark($id){
        if (self::where('id', $id)->exists())
        	self::find($id)->delete();
    }

}