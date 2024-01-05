<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;

use App\Models\V1\Comments\Comment;
use App\Models\V1\Comments\CommentsLike;

class CommentsFacade extends MainFacade{

    public function getList($source_id, $source, $parent_id = 0){

        return Comment::getList($source_id, $source, $parent_id);

    }

    public function loadComment($comment_id){
        return Comment::getComment($comment_id);
    }

}