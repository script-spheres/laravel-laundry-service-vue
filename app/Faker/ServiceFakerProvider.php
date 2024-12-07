<?php

namespace App\Faker;

use Faker\Provider\Base;

class ServiceFakerProvider extends Base
{
    protected static array $serviceTypes = [
        'Wash, Dry, and Fold',
        'Wash and Iron',
        'Dry Cleaning',
        'Express Laundry Service',
        'Delicate Fabric Care',
        'Stain Removal Services',
        'Curtain and Drapery Cleaning',
        'Carpet and Rug Cleaning',
        'Bedding and Linen Cleaning',
        'Hotel and Hospitality Laundry',
        'Medical Laundry',
        'Restaurant Laundry',
        'Industrial Laundry',
        'Self-Service Laundromat',
        'Leather and Suede Cleaning',
        'Pet Laundry',
        'Shoe Cleaning',
        'Alteration and Repairs',
        'Green Laundry',
    ];

    /**
     * Returns a random service type name from the predefined list.
     *
     * @return string
     */
    public static function serviceTypeName(): string
    {
        return static::randomElement(static::$serviceTypes);
    }
}
