<?php
namespace App\Models\V1\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model{

	private $descriptor = false;

	
	
	public $timestamps = false;
	
	protected $fillable = ['person_id', 'target_id', 'born_fio', 'action', 'date', 'address', 'price', 'html', 'genom', 'details', 
		'reminders_count', 'views', 'comments_count', 'email', 'phone', 'user_id', 'is_approved', 'approved_user_id', 'info', 'teip', 'permission', 'title', 'contacts'];
	// protected $table = 'links';

	private function setDescriptor(){
		$this->descriptor = self::leftJoin('users', 'users.id', '=', 'events.user_id');
		$this->descriptor->leftJoin('data as pd', 'pd.id', '=', 'events.person_id')
							->leftJoin('data as td', 'td.id', '=', 'events.target_id');
		return $this;
	}

	public function descriptor(){
		return $this->descriptor;
	}

	public function isApproved($value){
		if (!$this->descriptor) $this->setDescriptor();
		$this->descriptor->where('events.is_approved', $value);
		return $this;
	}

	public function setOrder($by, $to){
		if (!$this->descriptor) $this->setDescriptor();
		$this->descriptor->orderBy($by, $to);
		return $this;
	}

	public function setType($type){
		if (!$this->descriptor) $this->setDescriptor();
		$this->descriptor->where('events.type', $type);
		return $this;
	}

	public function setAncestors($ancestors, $request, $current_user, $family, $subs){
		if (!$this->descriptor) $this->setDescriptor();
		if ($request->has('lines')){
			$this->descriptor->where(function($query) use($ancestors, $request, $current_user){
				foreach ($request->lines as $line){
					if (isset($subs[$line])){
						$query->orWhere(function($q) use($ancestors, $line, $current_user){
							if (in_array($line, ['father', 'mather', 'spouce'])){
								$q->where(function($qu) use($ancestors, $line){
									$qu->orWhere('events.genom', 'like', '% '.$ancestors[$line].' %')
									->orWhere('events.genom', 'like', $ancestors[$line].' %')
									->orWhere('events.genom', 'like', '% '.$ancestors[$line]);
								})->where('events.permission', 'teip');
							}else{
								if ($line == 'subscribers'){
									$q->whereIn('events.user_id', $subs)->where('permission', 'subscribers');
								}else if ($line == 'family'){
									$q->whereIn('events.user_id', $family)->where('permission', 'family');
								}else if ($line == 'my'){
									$q->where('events.user_id', auth()->id());
								}
							}
						});
					}
				}
			});
		}
		return $this;
	}

	public function getData(){
		return $this->descriptor->
					select('events.*', 'users.nickname', 'users.profile_photo_path as avatar', 'users.username',
							'pd.fio as person_fio', 'pd.pol as person_pol', 'pd.teip as person_teip', 'pd.user_id as person_user_id',
							'td.fio as target_fio', 'td.pol as target_pol', 'td.teip as target_teip', 'td.user_id as target_user_id')->
					paginate(15);
	}

	public function getEvent($event_id){
		if (!$this->descriptor) $this->setDescriptor();
	
		return $this->descriptor
				->where('events.id', $event_id)
				->select('events.*', 'users.nickname', 'users.profile_photo_path as avatar', 'users.username',
						'pd.fio as person_fio', 'pd.pol as person_pol', 'pd.teip as person_teip', 'pd.user_id as person_user_id',
						'td.fio as target_fio', 'td.pol as target_pol', 'td.teip as target_teip', 'td.user_id as target_user_id')
				->first();
	}
	
}