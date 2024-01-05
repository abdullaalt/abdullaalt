<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallPostActionContract;
use App\Services\V1\Wall\WallPostService;

use App\Http\Resources\V1\Wall\PostResource;

//use App\Http\Resources\V1\Users\UserResource;

class WallPostAction implements WallPostActionContract{
 
    public function __invoke($post_id) {

        $post = new WallPostService();
        
        return $post->getPost($post_id)
                    ->setUser(auth()->id())
                    ->isAccessToPost()
                    ->preparingSingleResult()
                    ->addDataToResponse(PostResource::class)
                    ->response()
                    ->json();

    }

}