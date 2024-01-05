<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;


use App\Contracts\Comments\CommentsActionContract;
use App\Contracts\Comments\CommentsAddActionContract;
use App\Contracts\Comments\CommentsSubActionContract;
use App\Contracts\Comments\CommentsDeleteActionContract;

//use App\Contracts\Users\UserInfoActionContract;

use App\Http\Requests\Comments\CommentRequest;

//use App\Models\instConProf;

class CommentsController extends Controller {
    public function getSourceCommentsList($source_id, $source, CommentsActionContract $CommentsActionContract){
        return $CommentsActionContract($source_id, $source);
    }
    public function getSourceSubCommentsList($source_id, $source, $parent_id, CommentsSubActionContract $CommentsSubActionContract){
        return $CommentsSubActionContract($source_id, $source, $parent_id);
    }
    public function store(CommentRequest $request, CommentsAddActionContract $CommentsAddActionContract){
        return $CommentsAddActionContract($request->validated());
    }
    public function deleteComment($comment_id, CommentsDeleteActionContract $CommentsDeleteActionContract){
        return $CommentsDeleteActionContract($comment_id);
    }
}