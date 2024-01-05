<?php

namespace App\Contracts\Comments;

interface CommentsAddActionContract
{
    public function __invoke($request);

    public function addComment($request);

    public function editComment($request);
}