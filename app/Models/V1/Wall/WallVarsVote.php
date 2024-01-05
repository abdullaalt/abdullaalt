<?php
namespace App\Models\V1\Wall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\NotificationsController;

class WallVarsVote extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'var_id', 'post_id'];

    protected $table = 'wall_vars_vote';

	public static function isVoted($var_id, $user_id){
        return self::where('var_id', $var_id)
                    ->where('user_id', $user_id)
                    ->exists();
    }

	public static function addVote($var_id, $user_id, $post_id){
		self::create([
			'user_id' => $user_id,
			'var_id' => $var_id,
			'post_id' => $post_id
		]);

		return self::where('var_id', $var_id)->count();
	}

	public static function removeVote($var_id, $user_id, $post_id){
		self::where('var_id', $var_id)
                ->where('user_id', $user_id)
				->delete();

		return self::where('var_id', $var_id)->count();
	}

	public static function deleteVarVotes($var_id){
		self::where('var_id', $var_id)
				->delete();
	}

	public static function getVotedList($post_id){
		return self::where('post_id', $post_id)
				->leftJoin('users as u', 'u.id', '=', 'wall_vars_vote.user_id')
				->select('u.id', 'u.username', 'u.nickname', 'u.profile_photo_path')
				->paginate(20);
	}

}