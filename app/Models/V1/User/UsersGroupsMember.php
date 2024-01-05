<?php
namespace App\Models\V1\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersGroupsMember extends Model{
	
	protected $fillable = ['user_id', 'group_id'];
	public $timestamps = false;

    public static function getUserGroup($user_id){
        return self::where('user_id', $user_id)->first();
    }

}