<?php
namespace App\Http\Resources\V1\Comments;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\UserCardResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        //if (count($this->resource) < 1) return false;

        return [
            "id" => @$this->id,
            "pubdate"=> $this->created_at,
            "format_pubdate"=> dtt($this->created_at),
            "text"=> $this->text,
            "parent_id"=> $this->parent_id,
            "root_parent"=> $this->root_parent,
            "likes"=> $this->likes,
            "is_liked"=> (bool)$this->is_liked,
            "childs_count"=> $this->childs_count,
            "like_url"=> @$this->like_url,
            'user' => new UserCardResource($this)
        ];
    }
}