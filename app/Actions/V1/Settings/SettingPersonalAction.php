<?php
namespace App\Actions\V1\Settings;

use App\Contracts\Settings\SettingPersonalActionContract;

use App\Services\V1\Settings\SettingsService;

use App\Http\Resources\V1\Users\ProfileResource;

class SettingPersonalAction implements SettingPersonalActionContract
{

    public function __invoke($request)
    {

        $user_id = $request->has('user_id') ? $request->user_id : auth()->id();
        $settings = new SettingsService($user_id);

        if ($settings->user()->response()->isFail()){
            return $settings->user()->response()->json();
        }

        if (!$settings->permissions()->havePermissions('edit', $user_id)){
            return $settings->permissions()->fail403();
        }
        
        $settings->user()->fillData(($request->all()));

        if ($request->file('avatar')){
            $settings->user()->deleteAvatar();
            $settings->user()->uploadAvatar($request->file('avatar'));
        }

        $settings->user()->saveData();

        return $settings
            ->user()
            ->addDataToResponse(ProfileResource::class)
            ->response()
            ->json();

    }

}