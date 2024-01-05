<?php
namespace App\Services\V1\Comments;

use Response;
use Errors;

use App\Models\V1\Comments\Comment;
use App\Models\V1\Comments\CommentsLike;

use App\Http\Resources\V1\Users\UserSimpleResource;

class CommentsListService extends CommentsService{

    public function getCommentsList($source_id, $source, $parent_id = 0){
        
        $this->checkDataConditions($this->getList($source_id, $source, $parent_id), 'COMMENTS_NOT_FOUND');

        return $this;

    }

}