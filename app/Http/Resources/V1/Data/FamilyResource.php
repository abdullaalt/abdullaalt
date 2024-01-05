<?php
namespace App\Http\Resources\V1\Data;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'father' => @$this->father,
            'mather' => @$this->mather,
            'childs' => @$this->childs,
            'siblings' => @$this->siblings,
            'spouces' => @$this->spouces
        ];
    }
}