<?php
namespace App\Actions\V1\Users;

use App\Contracts\Users\UserInfoActionContract;
use App\Services\V1\Users\UserService;
use App\Services\V1\Users\GroupsService;
use App\Services\V1\Data\NodeService;
use App\Services\V1\Data\TeipsService;
use App\Services\V1\Data\FamilyService;

use App\Http\Resources\V1\Users\UserFullResource;

//use App\Http\Resources\V1\Users\UserResource;

class UserInfoAction implements UserInfoActionContract{
 
    public function __invoke($user_id) {

        $user = new UserService();
        $user->getUser($user_id);

        $group = new GroupsService();
        $group->getGroup($user_id, 'user_id');
        
        if ($user->response()->isFail()){
            return $user->response()->json();
        }

        if ($user->get('is_access'))
            $user->addProperty( 
                                    'node', 
                                    $user->loadForeignData(
                                                            NodeService::class, 
                                                            $user->get('tree_number')
                                                            )
                                         ->getForeightData()
                                 ) 
                    ->addProperty(
                                    'family', 
                                    $user->loadForeignData(
                                                            FamilyService::class, 
                                                            $user->get('tree_number')
                                                            )
                                         ->getForeightData()
                                );

        return $user->addProperty( 
                        'teip_item', 
                        $user->loadForeignData(
                                                TeipsService::class, 
                                                $user->get('teip')
                                                )
                            ->getForeightData()
                    )
                    ->addProperty('is_blocked', $user->isUserBlocked())
                    ->addProperty('group', $group->get())
                    ->addDataToResponse(UserFullResource::class)
                    ->response()
                    ->json();

    }

}