<?php
namespace App\Http\Resources\V1\Wall;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\UserCardResource;

class LikesResource extends JsonResource
{
    public function toArray($request)
    {
        //if (count($this->resource) < 1) return false;

        return [
            'user' => new UserCardResource((object)[
				"nickname"=> $this['nickname'],
				"id"=> $this['id'],
				"profile_photo_path"=> $this['profile_photo_path'],
				"username" => $this['username']
            ])
        ];
    }
}