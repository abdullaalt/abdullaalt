<?php

namespace App\Contracts\Comments;

interface CommentsDeleteActionContract
{
    public function __invoke($comment_id);
}