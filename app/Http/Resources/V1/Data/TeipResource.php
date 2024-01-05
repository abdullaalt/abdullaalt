<?php
namespace App\Http\Resources\V1\Data;

use Illuminate\Http\Resources\Json\JsonResource;

class TeipResource extends JsonResource
{
    public function toArray($request)
    {
        //if (count($this->resource) < 1) return false;
       
        return [
            "id" => $this->id,
            "title"=> $this->title,
            "parent_id"=> $this->parent_id,
            "user_id"=> $this->user_id,
            "born"=> $this->born,
            "format_born"=> dt($this->born),
            "die"=> $this->die,
            "format_die"=> dt($this->die),
            "pol"=> $this->pol,
            "bio"=> $this->bio,
            "avatar"=> print_image_src($this->avatar, 'medium')
        ];
    }
}