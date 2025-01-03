<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BusinessSettings extends Settings
{
    public ?string $address;
    public ?string $email;

    public static function group(): string
    {
        return 'business';
    }
}
