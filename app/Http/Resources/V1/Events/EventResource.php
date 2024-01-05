<?php
namespace App\Http\Resources\V1\Events;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\UserCardResource;
use App\Http\Resources\V1\Events\PersonResource;
use App\Http\Resources\V1\Data\TeipResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        $this->event_id = $this->id;
        $this->id = $this->user_id;
        $this->profile_photo_path = $this->avatar;
        
        return [
				"id"=> $this->event_id,
				"title"=> $this->title,
				"born_fio"=> $this->born_fio,
				"type"=> $this->type,
				"date"=> $this->date,
                "format_date" => dt($this->date),
                "address"=> $this->address,
                "price"=> $this->price,
                "date_pub"=> $this->date_pub,
                "format_date_pub" => dtt($this->date_pub),
                "details"=> $this->details,
                "info"=> $this->info,
                "reminders_count"=> $this->reminders_count,
                "views"=> $this->views,
                "comments_count"=> $this->comments_count,
                "contacts"=> $this->contacts,
                "user"=> new UserCardResource($this),
                "is_approved"=> (bool)$this->is_approved,
                "teip"=> $this->teip ? new TeipResource($this->teip) : null,
                "permission"=> $this->permission,
                "line"=> $this->line,
                "is_remind"=> (bool)$this->is_remind,
                $this->key1 => $this->person ? new PersonResource((object)$this->person) : $this->person,
                $this->key2 => $this->target ? new PersonResource((object)$this->person) : $this->target
				
        ];

    }
}