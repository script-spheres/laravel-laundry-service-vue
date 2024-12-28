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
            ['name' => 'Combo - Shirt and Pant', 'description' => 'A combo of matching shirt and pant for a complete look.'],
            ['name' => 'Dhoti Heavy', 'description' => 'A traditional heavy dhoti, ideal for cultural events.'],
            ['name' => 'Dhoti Normal', 'description' => 'A regular dhoti for daily or semi-formal wear.'],
            ['name' => 'Dhoti / Lungi ( Silk )', 'description' => 'Silk dhoti or lungi, perfect for weddings or celebrations.'],
            ['name' => 'Formal and Casual Trousers / Pants', 'description' => 'A range of trousers and pants for both formal and casual settings.'],
            ['name' => 'Gloves ( Leather )', 'description' => 'Leather gloves that provide both style and warmth.'],
            ['name' => 'Gloves ( Woolen )', 'description' => 'Woolen gloves, ideal for cold weather conditions.'],
            ['name' => 'Handkerchief', 'description' => 'A soft and absorbent handkerchief for daily use.'],
            ['name' => 'Hats', 'description' => 'Fashionable hats for sun protection and style.'],
            ['name' => 'Indo Western', 'description' => 'A fusion of traditional and modern wear, ideal for weddings.'],
            ['name' => 'Jacket - Faux fur Long', 'description' => 'A long faux fur jacket, perfect for cold climates and stylish wear.'],
            ['name' => 'Jacket - Faux fur Short', 'description' => 'A shorter faux fur jacket for more casual and trendy wear.'],
            ['name' => 'Jacket Leather', 'description' => 'A durable and stylish leather jacket for all seasons.'],
            ['name' => 'Jacket Normal Long', 'description' => 'A normal long jacket for both casual and formal wear.'],
            ['name' => 'Jacket Normal Short', 'description' => 'A short jacket for a relaxed and casual look.'],
            ['name' => 'Jacket Puffer Long', 'description' => 'A long puffer jacket, ideal for winter and outdoor activities.'],
            ['name' => 'Jacket Puffer Short', 'description' => 'A short puffer jacket for a lighter winter option.'],
            ['name' => 'Jacket Rexine', 'description' => 'A rexine jacket offering a stylish yet affordable alternative to leather.'],
            ['name' => 'Jeans', 'description' => 'Classic denim jeans for casual or semi-formal occasions.'],
            ['name' => 'Joggers', 'description' => 'Comfortable joggers for an active lifestyle and casual wear.'],
            ['name' => 'Kurta ( Cotton )', 'description' => 'A cotton kurta, perfect for traditional or semi-formal occasions.'],
            ['name' => 'Kurta ( Silk )', 'description' => 'A luxurious silk kurta, ideal for weddings and festive events.'],
            ['name' => 'Kurta Heavy', 'description' => 'A heavier fabric kurta for colder climates or formal events.'],
            ['name' => 'Kurta Payjama ( Heavy )', 'description' => 'A traditional kurta with a heavy payjama for special occasions.'],
            ['name' => 'Kurta Payjama ( Light )', 'description' => 'A lightweight version of the kurta payjama for casual wear.'],
            ['name' => 'Muffler ( Woolen / Pashmina )', 'description' => 'A woolen or pashmina muffler, perfect for winter wear.'],
            ['name' => 'Pagdi', 'description' => 'A traditional headpiece for formal or cultural events.'],
            ['name' => 'Parka Coat < Fur Inside > Long', 'description' => 'A long parka coat with fur inside for maximum warmth.'],
            ['name' => 'Parka Coat < Fur Inside > Short', 'description' => 'A short parka coat with fur inside for a stylish winter look.'],
            ['name' => 'Pocket Square', 'description' => 'A small decorative square cloth for the breast pocket of jackets.'],
            ['name' => 'Pyjama', 'description' => 'Comfortable pyjama for daily wear or sleepwear.'],
            ['name' => 'Safari Shirt & Pant', 'description' => 'A safari set with a shirt and pants for a rugged outdoor look.'],
            ['name' => 'Shawl - Pashmina', 'description' => 'A luxurious pashmina shawl for warmth and elegance.'],
            ['name' => 'Shawl - Toosh', 'description' => 'A traditional toosh shawl known for its fine fabric and warmth.'],
            ['name' => 'Shawl / Lohi', 'description' => 'A lohi shawl, often worn for ceremonial purposes.'],
            ['name' => 'Shawl / Naga', 'description' => 'A Naga shawl, part of cultural attire from the Naga tribes.'],
            ['name' => 'Sherwani', 'description' => 'An elegant traditional outfit for weddings and special events.'],
            ['name' => 'Shirt', 'description' => 'A classic shirt for formal or semi-formal occasions.'],
            ['name' => 'Shirt & Dhoti ( Silk )', 'description' => 'A combination of silk shirt and dhoti, perfect for cultural events.'],
            ['name' => 'Shoes Leather / Suede / Nubuck', 'description' => 'Stylish shoes made from leather, suede, or nubuck.'],
            ['name' => 'Shoes Sports', 'description' => 'Sports shoes designed for athletic performance and comfort.'],
            ['name' => 'Shorts', 'description' => 'Casual shorts for a relaxed summer look.'],
            ['name' => 'Socks Pair', 'description' => 'A pair of socks for everyday comfort.'],
            ['name' => 'Suit 2 Pc', 'description' => 'A two-piece suit, perfect for formal business wear.'],
            ['name' => 'Suit 3 Pc', 'description' => 'A three-piece suit for a formal and sophisticated appearance.'],
            ['name' => 'Sweater / Cardigan - Full Sleeve', 'description' => 'A full-sleeve sweater or cardigan for winter wear.'],
            ['name' => 'Sweater / Cardigan - Sleeveless', 'description' => 'A sleeveless sweater or cardigan for layering over shirts.'],
            ['name' => 'Sweatshirt / Jumper', 'description' => 'A casual sweatshirt or jumper for everyday wear.'],
            ['name' => 'Swimming Trunks', 'description' => 'Swimming trunks designed for comfort and performance in water.'],
            ['name' => 'Thermal', 'description' => 'Thermal wear for added warmth in cold climates.'],
            ['name' => 'Tie', 'description' => 'A formal tie to complement business or formal attire.'],
            ['name' => 'Track Pant', 'description' => 'Track pants designed for comfort and active wear.'],
            ['name' => 'Track Suit', 'description' => 'A full track suit for both casual and active use.'],
            ['name' => 'Trousers', 'description' => 'Formal or casual trousers for a refined look.'],
            ['name' => 'T - Shirt', 'description' => 'A simple and comfortable t-shirt for casual wear.'],
            ['name' => 'Turban', 'description' => 'A traditional turban worn for cultural and ceremonial purposes.'],
            ['name' => 'Vest', 'description' => 'A comfortable vest for casual wear or as an undergarment.'],
            ['name' => 'Waist Coat', 'description' => 'A waistcoat to complete a formal or semi-formal outfit.'],
            ['name' => 'Wallet', 'description' => 'A leather wallet for carrying cards and cash.'],
            ['name' => 'Wedding Sherwani set Designer', 'description' => 'A designer wedding sherwani set for the groom.'],
            ['name' => 'Wedding Sherwani set', 'description' => 'A traditional wedding sherwani set for formal ceremonies.'],
            ['name' => 'Wedding Suit ( 3 pcs )', 'description' => 'A three-piece suit designed for weddings and formal events.'],
            ['name' => 'Wedding Suit Designer ( 3 pcs )', 'description' => 'A designer three-piece wedding suit for a fashionable groom.'],
            ['name' => 'Wedding Tuxedo ( 3 pcs )', 'description' => 'A classic tuxedo for a wedding or upscale event.'],
            ['name' => 'Wedding Tuxedo Designer ( 3 pcs )', 'description' => 'A designer three-piece tuxedo for weddings and formal occasions.'],
            ['name' => 'Wind Cheater / Rain Jacket', 'description' => 'A wind cheater or rain jacket for protection from the elements.'],
        ]);

        $serviceItems->each(fn($item) => ServiceItem::factory()->create([
            'name' => $item['name'],
            'description' => $item['description']
        ]));
    }
}
