<?php
namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\GroupResource;

class UserCardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
				"nickname"=> $this->nickname,
				"user_id"=> $this->id,
				"avatar" => print_image_src($this->profile_photo_path, 'medium'),
                "avatars" => print_images_src($this->profile_photo_path),
				"username" => $this->username
        ];
    }
}