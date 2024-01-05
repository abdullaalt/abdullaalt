<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallUserActionContract;
use App\Services\V1\Users\UserService;
use App\Services\V1\Wall\WallService;

use App\Http\Resources\V1\Wall\PostResource;

//use App\Http\Resources\V1\Users\UserResource;

class WallUserAction implements WallUserActionContract{
 
    public function __invoke($user_id) {

        $wall = new WallService();
        $wall->getWall(false, $user_id);
        
        if ($wall->response()->isFail()){
            return $wall->response()->json();
        }

        return $wall
                ->extractPaginate()
                ->preparingResult($wall->get())
                ->addDataToResponse(PostResource::class, true)
                ->response()
                ->json();

    }

}