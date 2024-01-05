<?php

namespace App\Contracts\Users;

//use App\Http\Resources\V1\Users\UserResource;

interface UserInfoActionContract{
    public function __invoke($user_id);
} 