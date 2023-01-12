<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Suppliers;

class SuppliersFactory extends Factory
{
    protected $model = Suppliers::class;

    public function definition(): array
    {
    	return [
    	    'supplier_name' => $this->faker->name(),
            'contact' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
    	];
    }
}
