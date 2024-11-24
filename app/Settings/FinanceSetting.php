<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FinanceSetting extends Settings
{

    public static function group(): string
    {
        return 'default';
    }
}