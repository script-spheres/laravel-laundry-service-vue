<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.slogan');
        $this->migrator->add('general.logo');
        $this->migrator->add('general.favicon');
    }

    public function down(): void
    {
        $this->migrator->delete('general.slogan');
        $this->migrator->delete('general.logo');
        $this->migrator->delete('general.favicon');
    }
};
