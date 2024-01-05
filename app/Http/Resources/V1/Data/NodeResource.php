<?php
namespace App\Http\Resources\V1\Data;

use Illuminate\Http\Resources\Json\JsonResource;

class NodeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "node_id"=> $this->id,
            "fio"=> $this->fio,
            "user_id"=> $this->user_id,
            "born"=> $this->born,
            "format_born"=> dt($this->born),
            "die"=> $this->die,
            "format_die"=> dt($this->die),
            "pol"=> $this->pol,
            "gender"=> $this->pol == 2 ? 'female' : 'male',
            "bio"=> $this->bio,
            "avatar"=> print_image_src($this->avatar, 'medium')
        ];
    }
}