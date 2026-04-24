<?php

namespace Database\Seeders;

use App\Models\{Customer,Truck, Order };
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Truck::factory(10)->create();
        Customer::factory(10)->create();
        Order::factory(10)->create();
    }
}
