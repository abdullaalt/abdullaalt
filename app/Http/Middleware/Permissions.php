<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionsController;

class Permissions
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, $component)
    {
        $user = Auth::user();

        $user_controller = new UserController();
        $permissions_controller = new PermissionsController();
        if (!Auth::check()){
            $group = $user_controller->getGroupById(1);
        }else{
            $group = $user_controller->getUserGroup(Auth::id());
        }

        return $permissions_controller->checkGroupPermissions($group, $component, $next, $request);

        /*if ($is_limited){
            $headers = getallheaders();

            $app_id =isset($headers['User-Token']) || isset($headers['user-token']);
            if ($app_id){
                header('Content-Type: application/json');
                return responce()->json(['errors'=>'Доступ к Вашему аккаунту ограничен']);
            }else{
                $request->session()->flash('messages.error', 'Доступ к Вашему аккаунту ограничен');
                return redirect()->back();
            }
        }*/
    }
}
