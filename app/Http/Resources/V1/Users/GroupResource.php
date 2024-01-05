<?php
namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'name' => $this->name
        ];
    }
}