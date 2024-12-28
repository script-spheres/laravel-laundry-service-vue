<?php

namespace Database\Seeders;

use App\Models\AddonService;
use Illuminate\Database\Seeder;

class AddonServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Predefined service items to be added
        $addonServiceItems = collect([
            ['name' => 'Washing', 'description' => 'Regular washing of clothes', 'price' => 10.00],
            ['name' => 'Ironing', 'description' => 'Ironing of clothes', 'price' => 5.00],
            ['name' => 'Dry Cleaning', 'description' => 'Dry cleaning for delicate fabrics', 'price' => 15.00],
            ['name' => 'Fold Clothes', 'description' => 'Folding of clothes after wash', 'price' => 3.00],
            ['name' => 'Stain Removal', 'description' => 'Removal of stains from clothes', 'price' => 8.00],
            ['name' => 'Laundry Pickup', 'description' => 'Pickup service for laundry', 'price' => 5.00],
            ['name' => 'Laundry Delivery', 'description' => 'Delivery of laundry to customer\'s address', 'price' => 5.00],
            ['name' => 'Bed Linen Washing', 'description' => 'Washing of bed linen and sheets', 'price' => 12.00],
            ['name' => 'Curtain Cleaning', 'description' => 'Cleaning of curtains', 'price' => 20.00],
            ['name' => 'Shoe Cleaning', 'description' => 'Cleaning of shoes (all types)', 'price' => 10.00],
            ['name' => 'Bedding Set Cleaning', 'description' => 'Cleaning of bedding sets including pillow covers', 'price' => 18.00],
            ['name' => 'Blanket Cleaning', 'description' => 'Washing and cleaning of blankets', 'price' => 22.00],
            ['name' => 'Carpet Cleaning', 'description' => 'Cleaning of carpets', 'price' => 25.00],
            ['name' => 'Sofa Cleaning', 'description' => 'Cleaning and maintenance of sofas', 'price' => 30.00],
            ['name' => 'Curtain Ironing', 'description' => 'Ironing of curtains', 'price' => 12.00],
            ['name' => 'Pet Blanket Cleaning', 'description' => 'Cleaning of pet blankets and beds', 'price' => 10.00],
            ['name' => 'Wash & Fold Package', 'description' => 'Washing and folding of clothes in a package', 'price' => 30.00],
            ['name' => 'Shirt Ironing', 'description' => 'Ironing of shirts', 'price' => 4.00],
            ['name' => 'Heavy Duty Laundry', 'description' => 'Laundry for heavy-duty clothes like jackets, uniforms', 'price' => 20.00],
            ['name' => 'Special Fabric Care', 'description' => 'Special care for delicate fabrics like silk, wool', 'price' => 25.00],
        ]);

        $addonServiceItems->each(fn($item) => AddonService::factory()->create([
            'name' => $item['name'],
            'description' => $item['description'],
            'price' => $item['price']
        ]));

    }
}
