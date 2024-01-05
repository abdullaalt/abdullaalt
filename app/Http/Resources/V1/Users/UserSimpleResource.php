<?php
namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'token' => $this->token,
				"is_admin"=> (bool)$this->is_admin,
				"email"=> $this->email,
				"cent_token"=> @$centrifuge_info->token,
				"channel"=> @$centrifuge_info->channel,
				"nickname"=> $this->nickname,
				"username"=> $this->username,
				"avatar"=> print_image_src($this->profile_photo_path, 'medium'),
				"is_follow"=> (bool)$this->is_follow,
				"is_in_teip"=> (bool)$this->is_in_teip,
				"is_in_family"=> (bool)$this->is_in_family,
				"is_real"=> (bool)$this->is_real,
				"f_name"=> $this->f_name,
				"name"=> $this->name,
				"l_name"=> $this->l_name,
				"born"=> $this->born,
				"phone"=> $this->photo,
				"node_id"=> $this->tree_number,
				"tree_number"=> $this->tree_number,
				"pol"=> $this->pol,
				"gender"=> $this->pol == 2 ? 'female' : 'male',
				"user_id"=> $this->id
        ];
    }
}