<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?string $slogan;
    public ?array $logo;
    public ?array $favicon;

    public static function group(): string
    {
        return 'general';
    }
}
