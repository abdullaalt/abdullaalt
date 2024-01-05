<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallAddActionContract;
use App\Services\V1\Wall\WallStoreService;

use App\Http\Resources\V1\Wall\PostResource;

class WallAddAction implements WallAddActionContract{

    public function __invoke($request) {

        if ($request->has('post_id')){
            return $this->editPost($request);
        }else{
            return $this->addPost($request);
        }

    }

    public function editPost($request){
        $wall = new WallStoreService();
        $wall->getPost($request->post_id)
            ->setRequest($request)
            ->preparingData()
            ->editPost();

        return $wall->preparingSingleResult()
                    ->addDataToResponse(PostResource::class)
                    ->response()
                    ->json();
    }

    public function addPost($request){
        $wall = new WallStoreService();
        $wall->getPost(false)
            ->setRequest($request)
            ->preparingData()
            ->addPost();

        return $wall->preparingSingleResult()
                    ->addDataToResponse(PostResource::class)
                    ->response()
                    ->json();
    }

}