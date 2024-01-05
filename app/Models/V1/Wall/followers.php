<?php
namespace App\Models\V1\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class Follower extends Model{
	
	public $timestamps = true;
	
	protected $fillable = ['user_id', 'pubdate', 'media', 'text', 'views', 'comments_count', 'tags', 'permission', 'likes', 'propotions', 'comments_on'];

    protected $table = 'wall';

    public static function getPosts(){

    }

    public static function isFollower($who, $on_whom){

    }

}