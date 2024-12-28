<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faqs = collect([
            [
                'question' => 'What is dry cleaning?',
                'answer' => 'Dry cleaning is a process of cleaning clothes without using water. It uses special chemicals to clean delicate fabrics that could be damaged by water or heat.',
            ],
            [
                'question' => 'How long does the laundry service take?',
                'answer' => 'The time required for laundry service depends on the type of service requested. Typically, it takes 1-2 days for a standard laundry service, and express services may be completed within a few hours.',
            ],
            [
                'question' => 'What types of clothes can be dry cleaned?',
                'answer' => 'Dry cleaning is suitable for clothes made from delicate fabrics like wool, silk, velvet, and certain synthetics. It is also used for items like suits, dresses, and coats.',
            ],
            [
                'question' => 'Do you offer ironing services?',
                'answer' => 'Yes, we offer ironing services for all types of clothes. You can choose to have your clothes dry cleaned and ironed or washed and folded with ironing included.',
            ],
            [
                'question' => 'What is wash & fold service?',
                'answer' => 'Our wash & fold service involves washing your clothes in the laundry machine, drying them, and folding them neatly. It is ideal for everyday clothes like shirts, pants, and undergarments.',
            ],
            [
                'question' => 'Can I request special instructions for my laundry?',
                'answer' => 'Yes, you can provide specific instructions when dropping off your laundry. We will make sure to follow any special care instructions for your items.',
            ],
            [
                'question' => 'How do I track my laundry order?',
                'answer' => 'You can track the status of your laundry order by logging into your account on our website or app. We will also send you notifications when your order is ready for pickup.',
            ],
            [
                'question' => 'Do you offer laundry service for bedding and large items?',
                'answer' => 'Yes, we offer laundry services for large items like bed sheets, blankets, comforters, and curtains. They will be cleaned with the appropriate methods for such items.',
            ],
            [
                'question' => 'Are the detergents you use safe for sensitive skin?',
                'answer' => 'Yes, we use high-quality detergents that are gentle on your clothes and safe for sensitive skin. You can also request hypoallergenic detergents if you have specific skin sensitivities.',
            ],
            [
                'question' => 'What should I do if I lose an item during laundry service?',
                'answer' => 'If you lose an item during the laundry process, please contact our customer support immediately. We will investigate the matter and ensure your item is returned or replaced.',
            ],
        ]);

        $faqs->each(fn($faq) => Faq::factory()->create([
            'question' => $faq['question'],
            'answer' => $faq['answer'],
        ]));
    }
}
