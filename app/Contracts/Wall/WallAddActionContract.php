<?php

namespace App\Contracts\Wall;

//use App\Http\Resources\V1\Users\UserResource;

interface WallAddActionContract{
    public function __invoke($request);
    public function addPost($request);
    public function editPost($request);
} 