<?php
namespace App\Actions\V1\Settings;

use App\Contracts\Settings\SettingsUploadAvatarActionContract;

use App\Services\V1\Settings\SettingsService;

use App\Http\Resources\V1\Users\ProfileResource;

class SettingsUploadAvatarAction implements SettingsUploadAvatarActionContract
{

    public function __invoke($request)
    {
        
        $user_id = $request->has('user_id') ? $request->user_id : auth()->id();
        $settings = new SettingsService($user_id);

        if (!$settings->permissions()->havePermissions('edit', auth()->id())){
            return $settings->permissions()->fail403();
        }

        if ($request->file('avatar')){
            $settings->user()
                    ->deleteAvatar()
                    ->uploadAvatar($request->file('avatar'));
        }

        $settings->user()->saveData(['profile_photo_path']);

        return $settings
                ->user()
                ->addDataToResponse(ProfileResource::class)
                ->response()
                ->json();

    }

}