<?php
namespace App\Actions\V1\Users;

use App\Contracts\Users\UserActionContract;
use App\Services\V1\Users\UserService;
use App\Services\V1\Users\GroupsService;

use App\Http\Resources\V1\Users\ProfileResource;

//use App\Http\Resources\V1\Users\UserResource;

class UserAction implements UserActionContract{
 
    public function __invoke() {
        
        $user = new UserService();
        $user->getUser(auth()->id());

        $group = new GroupsService();
        $group->getGroup(auth()->id(), 'user_id');
        
        return $user->addDataToResponse(ProfileResource::class)
                    ->addProperty('is_blocked', $user->isUserBlocked())
                    ->addProperty('group', $group->get())
                    ->response()
                    ->json();

    }

}