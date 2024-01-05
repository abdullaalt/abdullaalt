<?php

namespace App\Contracts\Comments;

//use App\Http\Resources\V1\Users\UserResource;

interface CommentsActionContract{
    public function __invoke($source_id, $source);
} 