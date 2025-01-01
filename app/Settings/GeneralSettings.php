<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $slogan;
    public string $logo;
    public string $favicon;

    public static function group(): string
    {
        return 'general';
    }
}
