<?php

namespace Database\Factories;

use App\Models\warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    protected $model = warehouse::class;

    public function definition(): array
    {
    	return [
    	    'supplier_id' => $this->faker->uuid(),
            'supplier_name' => $this->faker->name(),
            'contact' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
    	];
    }
}
