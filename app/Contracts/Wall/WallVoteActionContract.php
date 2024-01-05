<?php

namespace App\Contracts\Wall;

//use App\Http\Resources\V1\Users\UserResource;

interface WallVoteActionContract{
    public function __invoke($var_id);
} 