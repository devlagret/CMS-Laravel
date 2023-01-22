<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    protected $model = Categories::class;

    public function definition(): array
    {
        $category = $this->faker->randomElement(['Pangan', 'Non-Pangan']);

    	return [
            'category_id' => $this->faker->uuid(),
    	    'category_name' => $this->faker->lexify($category),
            'category_type' => $this->faker->lexify($category),
    	];
    }
}
