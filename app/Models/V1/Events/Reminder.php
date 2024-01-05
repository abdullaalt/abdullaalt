<?php
namespace App\Models\V1\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Reminder extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'event_id', 'date'];
	
    public function isRemind($event_id, $user_id){
        return self::where('user_id', $user_id)->where('event_id', $event_id)->exists();
    }
	
}