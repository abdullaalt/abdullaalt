<?php

namespace App\Contracts\Comments;

interface CommentsSubActionContract
{
    public function __invoke($source_id, $source, $parent_id);
}