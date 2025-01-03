<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FinanceSettings extends Settings
{

    public ?float $tax_rate;
    public ?string $currency;
    public ?string $currency_symbol;

    public static function group(): string
    {
        return 'finance';
    }
}
