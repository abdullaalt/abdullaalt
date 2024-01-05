<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallLikesListActionContract;
use App\Services\V1\Wall\WallPostService;

use App\Http\Resources\V1\Wall\LikesResource;

class WallLikesListAction implements WallLikesListActionContract{
 
    public function __invoke($post_id) {

        $post = new WallPostService();
        
        $post->getPost($post_id)
                    ->setUser(auth()->id())
                    ->isAccessToPost()
                    ->addProperty('is_liked', $post->isPostLiked($post_id, auth()->id()));
        
        if ($post->response()->isFail()){
            return $post->response()->json();
        }
        
        $post->getLikesList()
                    ->extractPaginate()
                    ->extractData();
        
        return $post->addDataToResponse(LikesResource::class, true)
                    ->response()
                    ->json();

    }

}