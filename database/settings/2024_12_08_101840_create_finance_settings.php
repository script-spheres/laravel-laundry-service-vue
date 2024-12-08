<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('finance.tax_rate', 0.0);
        $this->migrator->add('finance.currency', 'USD');
    }

    public function down(): void
    {
        $this->migrator->delete('finance.tax_rate');
        $this->migrator->delete('finance.currency');
    }
};
