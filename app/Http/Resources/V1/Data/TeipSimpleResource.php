<?php
namespace App\Http\Resources\V1\Data;

use Illuminate\Http\Resources\Json\JsonResource;

class TeipSimpleResource extends JsonResource
{
    public function toArray($request)
    {        
        return [
            "id" => $this->id,
            "title"=> $this->title,
            "parent_id"=> $this->parent_id,
            "photo"=> print_image_src($this->avatar, 'medium'),
            "cover"=> print_image_src($this->avatar, 'original')
        ];
    }
}