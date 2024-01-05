<?php
namespace App\Actions\V1\Comments;

use App\Contracts\Comments\CommentsAddActionContract;

use App\Services\V1\Comments\CommentsService;

use App\Http\Resources\V1\Comments\CommentResource;

class CommentsAddAction implements CommentsAddActionContract
{

    public function __invoke($request)
    {

        if (isset($request['comment_id'])){
            return $this->editComment($request);
        }else{
            return $this->addComment($request);
        }

    }

    public function addComment($request){
        $comment = new CommentsService();

        $comment->checkAddPermissions($request['source_id'], $request['source'], auth()->id());

        if ($comment->response()->isFail()){
            return $comment->response()->json();
        }

        $comment->getComment(false)
                ->setData((object)$request)
                ->addProperty('user_id', auth()->id());
        
        $comment->saveData()
                ->getComment($comment->get('id'))
                ->addProperty('is_liked', false)
                ->addProperty('childs_count', 0);

        return $comment
                ->addDataToResponse(CommentResource::class)
                ->response()
                ->json();

    }

    public function editComment($request){
        $comment = new CommentsService();

        $comment->checkAddPermissions($request['source_id'], $request['source'], auth()->id());

        if ($comment->response()->isFail()){
            return $comment->response()->json();
        }

        $comment->getComment($request['comment_id']);
        
        if (!$comment->checkEditPermissions()){
            return $comment->response()->json();
        }

        $comment->fillData($request);
        
        $comment->saveData()
                ->getComment($comment->get('id'))
                ->addProperty('is_liked', $comment->isLikedComment($request['comment_id']))
                ->addProperty('childs_count', $comment->getCommentChildsCount($request['comment_id']));

        return $comment
                ->addDataToResponse(CommentResource::class)
                ->response()
                ->json();

    }

}