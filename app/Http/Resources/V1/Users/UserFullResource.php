<?php
namespace App\Http\Resources\V1\Users;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\V1\Users\UserSimpleResource;
use App\Http\Resources\V1\Users\ProfileResource;
use App\Http\Resources\V1\Data\NodeResource;
use App\Http\Resources\V1\Data\TeipSimpleResource;
use App\Http\Resources\V1\Data\FamilyResource;

class UserFullResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'profile' => new ProfileResource($this),
            'about_profile' => new AboutProfileResource($this),
            'item' => $this->node ? new NodeResource($this->node) : null,
            'teip_item' => $this->teip_item ? new TeipSimpleResource($this->teip_item) : null,
            'family' => $this->family ? new FamilyResource($this->family) : null,
        ];
    }
}