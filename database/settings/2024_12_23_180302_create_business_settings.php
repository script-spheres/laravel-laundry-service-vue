<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('business.country');
        $this->migrator->add('business.country_code');
        $this->migrator->add('business.state');
        $this->migrator->add('business.city');
        $this->migrator->add('business.district');
        $this->migrator->add('business.zip_code');
        $this->migrator->add('business.email');
        $this->migrator->add('business.address');
    }

    public function down(): void
    {
        $this->migrator->delete('business.country');
        $this->migrator->delete('business.country_code');
        $this->migrator->delete('business.state');
        $this->migrator->delete('business.city');
        $this->migrator->delete('business.district');
        $this->migrator->delete('business.zip_code');
        $this->migrator->delete('business.email');
        $this->migrator->delete('business.address');
    }
};
