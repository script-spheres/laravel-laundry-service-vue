<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = collect([
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone_number' => '1234567890', 'address' => '123 Main St, City, Country'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone_number' => '9876543210', 'address' => '456 Oak St, City, Country'],
            ['name' => 'Michael Johnson', 'email' => 'michael@example.com', 'phone_number' => '1122334455', 'address' => '789 Pine St, City, Country'],
            ['name' => 'Emily Davis', 'email' => 'emily@example.com', 'phone_number' => '6677889900', 'address' => '101 Maple St, City, Country'],
            ['name' => 'David Wilson', 'email' => 'david@example.com', 'phone_number' => '3344556677', 'address' => '202 Birch St, City, Country'],
            ['name' => 'Sarah Brown', 'email' => 'sarah@example.com', 'phone_number' => '8899776655', 'address' => '303 Cedar St, City, Country'],
            ['name' => 'Chris Moore', 'email' => 'chris@example.com', 'phone_number' => '4455667788', 'address' => '404 Pine St, City, Country'],
            ['name' => 'Jessica Taylor', 'email' => 'jessica@example.com', 'phone_number' => '5566778899', 'address' => '505 Elm St, City, Country'],
            ['name' => 'Daniel Anderson', 'email' => 'daniel@example.com', 'phone_number' => '2233445566', 'address' => '606 Ash St, City, Country'],
            ['name' => 'Olivia Thomas', 'email' => 'olivia@example.com', 'phone_number' => '3344556677', 'address' => '707 Oak St, City, Country'],
        ]);

        // Loop through the customer data and create records with "(Test Customer)" appended to the name
        $customers->each(fn($customer) => Customer::create([
            'name' => $customer['name'] . ' (Test Customer)',
            'email' => $customer['email'],
            'phone_number' => $customer['phone_number'],
            'address' => $customer['address']
        ]));
    }
}
