<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallLikeActionContract;
use App\Services\V1\Wall\WallPostService;

class WallLikeAction implements WallLikeActionContract{
 
    public function __invoke($post_id) {

        $post = new WallPostService();
        
        $post->getPost($post_id)
                    ->setUser(auth()->id())
                    ->isAccessToPost()
                    ->addProperty('is_liked', $post->isPostLiked($post_id, auth()->id()));
        
        if ($post->response()->isFail()){
            return $post->response()->json();
        }

        if (!$post->get('is_liked')){
            $post->incrementLikes($post_id)->saveData(['likes']);
        }else{
            $post->decrementLikes($post_id)->saveData(['likes']);
        }

        return [
            'pressed' => $post->get('is_liked'),
            'likes' => $post->get('likes')
        ];

    }

}