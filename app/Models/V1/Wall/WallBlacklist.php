<?php
namespace App\Models\V1\Wall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\NotificationsController;

class WallBlacklist extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'post_id', 'reason_id', 'reason'];

    protected $table = "wall_blacklist";

    public static function isFollower($who, $on_whom){ //является ли подписчиком 
        return self::where('user_id', $who)->where('subs_id', $on_whom)->exists();
    }

    public static function getBlacklist($user_id){ //получаем подписки пользователя
        return self::where('user_id', $user_id)->get();
    }

}