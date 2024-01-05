<?php
namespace App\Providers;

use App\Contracts\Settings\SettingPersonalActionContract;
use App\Actions\V1\Settings\SettingPersonalAction;

use App\Contracts\Settings\SettingsDeleteAvatarActionContract;
use App\Actions\V1\Settings\SettingsDeleteAvatarAction;

use App\Contracts\Settings\SettingsUploadAvatarActionContract;
use App\Actions\V1\Settings\SettingsUploadAvatarAction;

use Illuminate\Support\ServiceProvider;

class SettingsActionsServiceProvider extends ServiceProvider
{
    /** 
     * Bootstrap the application services. 
     * 
     * @return void 
     */
    public function boot()
    {
        // 
    }

    /** 
     * Register the application services. 
     * 
     * @return void 
     */
    public array $bindings = [

        SettingPersonalActionContract::class => SettingPersonalAction::class,
        SettingsDeleteAvatarActionContract::class => SettingsDeleteAvatarAction::class,
        SettingsUploadAvatarActionContract::class => SettingsUploadAvatarAction::class,

    ];
}