<?php

namespace Database\Seeders;

use App\Models\ServiceItem;
use App\Models\ServicePrice;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ServiceItem::factory()
            ->count(10)
            ->create()
            ->each(function (ServiceItem $serviceItem) {
                // Get unique service type IDs in random order
                $randomServiceTypeIds = ServiceType::inRandomOrder()
                    ->pluck('id')
                    ->unique()
                    ->take(rand(1, 5)); // Limit to 1-5 unique service types

                // Create a service price for each selected service type
                $randomServiceTypeIds->each(function ($serviceTypeId) use ($serviceItem) {
                    ServicePrice::factory()->create([
                        'service_item_id' => $serviceItem->id,
                        'service_type_id' => $serviceTypeId,
                    ]);
                });
            });
    }
}
