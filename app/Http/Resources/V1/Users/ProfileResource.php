<?php
namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\GroupResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
				"nickname"=> $this->nickname,
				"user_id"=> $this->id,
				"avatar" => print_image_src($this->profile_photo_path, 'medium'),
				"username" => $this->username,
				"is_blocked" => $this->is_blocked,
				"is_open" => (bool)$this->is_open,
				"is_access" => $this->is_access,
				"is_follow"=> (bool)$this->is_follow,
				"is_in_teip"=> (bool)$this->is_in_teip,
				"is_in_family"=> (bool)$this->is_in_family,
				"group" => $this->group ? new GroupResource($this->group) : null,
				"is_real" => (bool)$this->is_real,
				"can_edit" => $this->id == auth()->id() || $this->is_admin,
				"is_my_profile" => $this->id == auth()->id(),
				"profile_type" => "profile",
				"is_my_teip" => $this->teip == auth()->user()->teip,
				"childs" => null,
				"count" => null,
				"teip" => $this->teip,
				"node_id" => $this->tree_number

				// "is_contact" => true,
				// "can_view_profile"=> true,
				// "is_trusted": false,
				// "is_subscribed": true,
				// "avatar_small": "/storage/app/users/12/thumbnail/abcf09ce754e783add232642b83944ac.jpg",
				// "followers": 12,
				// "follows": 6,
				// "posts": 23,
				// "is_follow": true,
				// "is_my_teip": false,
        ];
    }
}