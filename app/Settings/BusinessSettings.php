<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BusinessSettings extends Settings
{
    public string $address;
    public string $city;
    public string $state;
    public string $country;
    public string $zip_code;
    public string $email;
    public string $tax_number;
    public string $country_code;

    public static function group(): string
    {
        return 'business';
    }
}
