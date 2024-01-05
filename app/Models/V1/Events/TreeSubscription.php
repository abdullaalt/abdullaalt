<?php
namespace App\Models\V1\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TreeSubscription extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'subs_id', 'priority', 'line'];
	// protected $table = 'links';

    public function getUserSubs($user_id){
        $subs = self::where('user_id', $user_id)->select('subs_id')->get();
		$ids = [];
		foreach ($subs as $key => $value) {
			$ids[] = $value->subs_id;
		}

		return $ids;
    }

	public function isSubscribers($user_id, $subs_id){
		return self::where('user_id', $user_id)->where('subs_id', $subs_id)->exists();
	}
	
}