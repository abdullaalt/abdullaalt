<?php
namespace App\Actions\V1\Comments;

use App\Contracts\Comments\CommentsActionContract;
use App\Services\V1\Users\UserService;
use App\Services\V1\Comments\CommentsListService;

use App\Http\Resources\V1\Comments\CommentResource;

//use App\Http\Resources\V1\Users\UserResource;

class CommentsAction implements CommentsActionContract{
 
    public function __invoke($source_id, $source) {
        
        $comments = new CommentsListService();

        $comments->getCommentsList($source_id, $source);

        if ($comments->response()->isFail()){
            return $comments->response()->json();
        }

        return $comments->extractPaginate()
                ->extractData()
                ->addDataToResponse(CommentResource::class, true)
                ->response()
                ->json();

    }

}