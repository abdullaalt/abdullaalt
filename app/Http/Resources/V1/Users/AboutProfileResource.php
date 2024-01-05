<?php
namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
				"fio"=> $this->nickname,
				"date"=> $this->born,
				"born"=> dt($this->born),
				"teip_id"=> $this->teip,
				"teip_title"=> @$this->teip_item->title,
				"region"=> 'Ингушетия',
        ];
    }
}