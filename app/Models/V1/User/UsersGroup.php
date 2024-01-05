<?php
namespace App\Models\V1\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersGroup extends Model{
	
	protected $fillable = ['name', 'title', 'is_fixed', 'is_public', 'is_filter'];
	public $timestamps = false;

    public static function getGroup($group_id){
        return self::find($group_id);
    }

}