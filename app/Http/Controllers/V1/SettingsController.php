<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

use App\Contracts\Settings\SettingPersonalActionContract;
use App\Contracts\Settings\SettingsDeleteAvatarActionContract;
use App\Contracts\Settings\SettingsUploadAvatarActionContract;

use App\Http\Requests\Settings\ProfileRequest;

//use App\Models\instConProf;

class SettingsController extends Controller {

    public function saveProfile(ProfileRequest $request, SettingPersonalActionContract $SettingPersonalActionContract){
       
        return $SettingPersonalActionContract($request);

    }

    public function deleteAvatar(Request $request, SettingsDeleteAvatarActionContract $SettingsDeleteAvatarActionContract){
        return $SettingsDeleteAvatarActionContract($request);
    }

    public function uploadAvatar(Request $request, SettingsUploadAvatarActionContract $SettingsUploadAvatarActionContract){
        return $SettingsUploadAvatarActionContract($request);
    }

}