<?php

namespace Database\Seeders;

use App\Models\Products;
use Database\Factories\ProductsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Factory(Products::class, 10)->create();
        // ProductsFactory::factory()->count(10)->create();
        Products::factory()->count(10)->create();
    }
}
