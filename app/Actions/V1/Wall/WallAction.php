<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallActionContract;
use App\Services\V1\Users\UserService;
use App\Services\V1\Wall\WallService;

use App\Http\Resources\V1\Wall\PostResource;

//use App\Http\Resources\V1\Users\UserResource;

class WallAction implements WallActionContract{
 
    public function __invoke() {

        $wall = new WallService();
        $wall->getWall();

        return $wall
                ->extractPaginate()
                ->preparingResult($wall->get())
                ->addDataToResponse(PostResource::class, true)
                ->response()
                ->json();

    }

}