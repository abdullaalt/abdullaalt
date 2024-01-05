<?php
namespace App\Actions\V1\Comments;

use App\Contracts\Comments\CommentsSubActionContract;

use App\Services\V1\Comments\CommentsListService;

use App\Http\Resources\V1\Comments\CommentResource;

class CommentsSubAction implements CommentsSubActionContract
{

    public function __invoke($source_id, $source, $parent_id)
    {

        $comments = new CommentsListService();

        $comments->getCommentsList($source_id, $source, $parent_id);

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