<?php
namespace App\Http\Resources\V1\Events;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          "fio"=> @$this->fio,
          "id"=> @$this->id,
          "pol"=> @$this->pol,
          "teip"=> @$this->teip,
          "user_id"=> @$this->user_id
        ];
    }
}