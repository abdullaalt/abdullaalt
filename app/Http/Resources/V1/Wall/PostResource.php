<?php
namespace App\Http\Resources\V1\Wall;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Users\UserCardResource;
use App\Http\Resources\V1\Comments\CommentResource;
use App\Http\Resources\V1\Marks\MarkResource;

use App\Services\V1\Media\MediaService;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        //if (count($this->resource) < 1) return false;
       
        $media = new MediaService();
        
        return [
            "id" => $this->id,
            "pubdate"=> $this->pubdate,
            "format_pubdate"=> dtt($this->pubdate),
            "media"=> $media->preparingMedia($this->media),
            "text"=> $this->text,
            "is_liked"=> $this->is_liked,
            "views"=> $this->views,
            "comments_count"=> $this->comments_count,
            "permission"=> $this->permission,
            "likes"=> $this->likes,
            "proportions"=> json_decode($this->proportions),
            "have_deaths"=> (bool)$this->have_deaths,
            "comments_on"=> (bool)$this->comments_on,
            "vote_info"=> $this->vote_info,
            "marked_users"=> $this->marked_users ? MarkResource::collection($this->marked_users) : null,
            "comment"=> $this->comment ? new CommentResource($this->comment) : null,
            'user' => new UserCardResource($this)
        ];
    }
}