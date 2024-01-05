<?php

namespace App\Contracts\Wall;

//use App\Http\Resources\V1\Users\UserResource;

interface WallUserActionContract{
    public function __invoke($user_id);
} 