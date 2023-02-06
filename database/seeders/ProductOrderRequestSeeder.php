<?php

namespace Database\Seeders;

use App\Models\ProductOrderRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductOrderRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductOrderRequest::factory()->count(5)->create();
    }
}
