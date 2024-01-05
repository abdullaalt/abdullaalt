<?php

namespace App\Contracts\Settings;

interface SettingPersonalActionContract
{
    public function __invoke($request);
}