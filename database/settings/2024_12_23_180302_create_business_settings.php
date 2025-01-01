<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('business.country', 'India');
        $this->migrator->add('business.country_code', '+91');
        $this->migrator->add('business.state', 'xxxxxxxxxx');
        $this->migrator->add('business.city', 'xxxxxxxxxx');
        $this->migrator->add('business.district', 'xxxxxxxxxx');
        $this->migrator->add('business.zip_code', 'xxxxxxxxxx');
        $this->migrator->add('business.store_email', 'test@test.com');
        $this->migrator->add('business.store_tax_number', 'xxxxxxxxxx');
        $this->migrator->add('business.address', 'Some address');
    }

    public function down(): void
    {
        $this->migrator->delete('business.country');
        $this->migrator->delete('business.country_code');
        $this->migrator->delete('business.state');
        $this->migrator->delete('business.city');
        $this->migrator->delete('business.district');
        $this->migrator->delete('business.zip_code');
        $this->migrator->delete('business.store_email');
        $this->migrator->delete('business.store_tax_number');
        $this->migrator->delete('business.address');
    }
};
