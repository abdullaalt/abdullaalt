<?php
namespace App\Actions\V1\Comments;

use App\Contracts\Comments\CommentsDeleteActionContract;
use App\Services\V1\Comments\CommentsService;

class CommentsDeleteAction implements CommentsDeleteActionContract
{

    public function __invoke($comment_id)
    {

        $comment = new CommentsService();

        $comment->getComment($comment_id);

        if ($comment->response()->isFail()){
            return $comment->response()->json();
        }
        
        if (!$comment->checkEditPermissions()){
            return $comment->response()->json();
        }

        $comment->deleteComment($comment_id);

        return true;

    }

}