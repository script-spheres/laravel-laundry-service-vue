<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Spatie');
    }

    public function down(): void
    {
        $this->migrator->delete('general.site_name');
    }
};
