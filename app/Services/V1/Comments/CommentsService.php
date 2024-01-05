<?php
namespace App\Services\V1\Comments;

use Response;
use Errors;

use App\Facades\CommentsFacade;

use App\Models\V1\Comments\Comment;
use App\Models\V1\Comments\CommentsLike;

use App\Services\V1\Wall\WallPostService;

use App\Http\Resources\V1\Users\UserSimpleResource;

class CommentsService extends CommentsFacade{

    public function getComment($comment_id){
        if (!$comment_id){
            $this->setData((object)[]);
            $this->setResponse(new Response([], 200));

            return $this;
        }
        $comment = $this->checkDataConditions($this->loadComment($comment_id), 'COMMENT_NOT_FOUND');
        return $this;
    }

    public function getMostLikedComment($source, $source_id){
        $comment = Comment::getCommentByRules($source, $source_id, 'likes', 'DESC');
        
        if ($comment){
            $comment->is_liked = $this->isLikedComment($comment->id);
            $this->setData($comment);
            $this->setResponse(new Response([], 200));
        }else{
            $this->setResponse(new Response([], 404));
        }

        return $this;
    }

    public function isLikedComment($comment_id){
        return CommentsLike::isLikedComment($comment_id);
    }

    public function getCommentChildsCount($comment_id){
        return Comment::getCommentChildsCount($comment_id);
    }

    public function checkAddPermissions($source_id, $source, $user_id){
        if ($source == 'post'){
            $result = (new WallPostService())->getPost($source_id)
                                            ->setUser($user_id)
                                            ->isAccessToPost();
        }

        $this->setResponse(new Response($result->response()->getData(), $result->response()->getCode()));

        return $this;
    }

    public function checkEditPermissions(){

        $access = true;
        
        if ($this->get('user_id') != auth()->id() && auth()->user()->is_admin){
            $access = false;
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('HAVE_NOT_PERMISSIONS')]
            ))->getErrors(), 403));
        }

        return $access;

    }

    public function saveData($array = false){
        
        $this->setData($this->save(Comment::class, $array));

        return $this;

    }

    public function deleteComment(int $comment_id){
        Comment::find($comment_id)->delete();
        CommentsLike::deleteLikes($comment_id);
    }

}