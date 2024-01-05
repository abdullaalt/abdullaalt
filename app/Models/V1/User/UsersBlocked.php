<?php
namespace App\Models\V1\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersBlocked extends Model{
	
	protected $fillable = ['user_id', 'blocked_user_id'];
	protected $table = 'users_blocked';
	public $timestamps = false;
	
	// public function append($request){
		
		// if (complainUsers::where('complain_user', $request->complain_user)->where('user_id', Auth::id())->exists()){
			// return true;
		// }
		// $complain = new complainUsers();
		
		// $complain->fill($request->all());
		// $complain->user_id = Auth::id();
		// $complain->save();
		
	// }

    public static function isBlocked($user_id){
		
		return UsersBlocked::where('user_id', auth()->id())->where('blocked_user_id', $user_id)->exists();
		
	}
	
}