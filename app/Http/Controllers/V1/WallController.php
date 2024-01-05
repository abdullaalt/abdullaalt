<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Requests\Wall\WallRequest;


use App\Contracts\Wall\WallActionContract;
use App\Contracts\Wall\WallUserActionContract;
use App\Contracts\Wall\WallLikesListActionContract;
use App\Contracts\Wall\WallVotesListActionContract;
use App\Contracts\Wall\WallLikeActionContract;
use App\Contracts\Wall\WallPostActionContract;
use App\Contracts\Wall\WallVoteActionContract;
use App\Contracts\Wall\WallVoteCancelActionContract;
use App\Contracts\Wall\WallAddActionContract;
//use App\Contracts\Users\UserInfoActionContract;

//use App\Http\Requests\RulesRequest;

//use App\Models\instConProf;

class WallController extends Controller {

    public function getWall(WallActionContract $WallActionContract){
        return $WallActionContract();
    }
    public function getUserWall($user_id, WallUserActionContract $WallUserActionContract){
        return $WallUserActionContract($user_id);
    }
    public function getPost($post_id, WallPostActionContract $WallPostActionContract){
        return $WallPostActionContract($post_id);
    }
    public function postLike($post_id, WallLikeActionContract $WallLikeActionContract){
        return $WallLikeActionContract($post_id);
    }
    public function voteVar($var_id, WallVoteActionContract $WallVoteActionContract){
        return $WallVoteActionContract($var_id);
    }
    public function cancelVar($var_id, WallVoteCancelActionContract $WallVoteCancelActionContract){
        return $WallVoteCancelActionContract($var_id);
    }
    public function store(WallRequest $request, WallAddActionContract $WallAddActionContract){
        return $WallAddActionContract($request);
    }
    public function postLikesList($post_id, WallLikesListActionContract $WallLikesListActionContract){
        return $WallLikesListActionContract($post_id);
    }
    public function postVotedUsersList($post_id, WallVotesListActionContract $WallVotesListActionContract){
        return $WallVotesListActionContract($post_id);
    }

}