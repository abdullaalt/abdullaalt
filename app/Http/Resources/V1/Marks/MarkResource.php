<?php
namespace App\Http\Resources\V1\Marks;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\UserCardResource;

class MarkResource extends JsonResource
{
    public function toArray($request)
    {
        $this->id = $this->user_id;
        $this->profile_photo_path = $this->avatar;
        return [
				"media_index"=> $this->media_index,
				"top_pos"=> $this->top_pos,
				"left_pos"=> $this->left_pos,
				"mark_id"=> $this->mark_id,
				"node_id"=> $this->node_id,
				"user"=> new UserCardResource($this)
        ];
    }
}