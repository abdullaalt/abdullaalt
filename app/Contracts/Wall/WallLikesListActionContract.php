<?php

namespace App\Contracts\Wall;

//use App\Http\Resources\V1\Users\UserResource;

interface WallLikesListActionContract{
    public function __invoke($post_id);
} 