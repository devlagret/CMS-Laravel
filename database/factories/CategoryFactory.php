<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $category_type = $this->faker->randomElement(['Non-Pangan','Pangan']);
        $p = $this->faker->randomElement(['Makanan Berat', 'Makanan Ringan']);
        $np = $this->faker->randomElement(['Kayu', 'Semen', 'Bata']);
        if (!strcmp($category_type, "Non-Pangan")) {
            $category_name = $np;
        } else {
            $category_name = $p;
        }
        $c = str_replace(['-', ' '], '', $category_type);
        $n = str_replace(' ', '', $category_name);
        $id = preg_replace('/([a-z])/', '', $c).'-'.preg_replace('/([a-z])/', '', $n);

    	return [
            'category_id' => $this->faker->lexify($id),
    	    'category_name' => $this->faker->lexify($category_name),
            'category_type' => $this->faker->lexify($category_type),
    	];
    }
}
