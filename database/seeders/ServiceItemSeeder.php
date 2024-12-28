<?php

namespace Database\Seeders;

use App\Models\ServiceItem;
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
        // Predefined service items with names and descriptions
        $serviceItems = collect([
            ['name' => 'Belt', 'description' => 'A stylish belt to complement your outfit.'],
            ['name' => 'Blazer / Coat - Long', 'description' => 'A formal long blazer or coat for professional occasions.'],
            ['name' => 'Blazer / Coat - Short', 'description' => 'A short blazer or coat, perfect for casual wear.'],
            ['name' => 'Boots leather', 'description' => 'Leather boots for a sophisticated and durable look.'],
            ['name' => 'Cap ( Casual / Woolen )', 'description' => 'Casual or woolen caps for both winter and fashion purposes.'],
            ['name' => 'Jacket - Faux fur Long', 'description' => 'A long faux fur jacket, perfect for cold climates and stylish wear.'],
            ['name' => 'Jacket - Faux fur Short', 'description' => 'A shorter faux fur jacket for more casual and trendy wear.'],
            ['name' => 'Jeans', 'description' => 'Classic denim jeans for casual or semi-formal occasions.'],
            ['name' => 'Joggers', 'description' => 'Comfortable joggers for an active lifestyle and casual wear.'],
            ['name' => 'Shirt', 'description' => 'A classic shirt for formal or semi-formal occasions.'],
            ['name' => 'Shoes Leather / Suede / Nubuck', 'description' => 'Stylish shoes made from leather, suede, or nubuck.'],
            ['name' => 'Shoes Sports', 'description' => 'Sports shoes designed for athletic performance and comfort.'],
            ['name' => 'Socks Pair', 'description' => 'A pair of socks for everyday comfort.'],
            ['name' => 'Suit 2 Pc', 'description' => 'A two-piece suit, perfect for formal business wear.'],
            ['name' => 'Sweater / Cardigan - Full Sleeve', 'description' => 'A full-sleeve sweater or cardigan for winter wear.'],
            ['name' => 'Sweatshirt / Jumper', 'description' => 'A casual sweatshirt or jumper for everyday wear.'],
            ['name' => 'Trousers', 'description' => 'Formal or casual trousers for a refined look.'],
            ['name' => 'T - Shirt', 'description' => 'A simple and comfortable t-shirt for casual wear.'],
            ['name' => 'Wallet', 'description' => 'A leather wallet for carrying cards and cash.'],
            ['name' => 'Wind Cheater / Rain Jacket', 'description' => 'A wind cheater or rain jacket for protection from the elements.'],
        ]);

        $serviceItems->each(fn($item) => ServiceItem::factory()->create([
            'name' => $item['name'],
            'description' => $item['description']
        ]));
    }
}
