<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Suppliers;

class ProductsFactory extends Factory
{
    protected $model = Products::class;

    public function definition(): array
    {
        $cateids = Categories::all()->pluck('id')->toArray();
        $suppids = Suppliers::all()->pluck('id')->toArray();
        $buy = $this->faker->numerify('###000');
        $price = $this->faker->numerify('###000');
        $price_rec = $this->faker->numerify('###000');
        $result = 'a';
         if($price > $buy){
            $result = round($price/$buy);
         }
         elseif ($buy > $price) {
            $result = round($buy/$price);
            $result =  -$result;
         }

    	return [
    	    'Product_Code' => $this->faker->bothify('?###'),
            'Brand' => $this->faker->company(),
            'Name' => $this->faker->name(),
            'category_id' => $this->faker->randomElement($cateids),
            'buy_price' => $this->faker->numerify($buy),
            'price_rec' => $this->faker->numerify($price),
            'price_rec_from_sup' => $this->faker->numerify($price_rec),
            'Profit_Margin' => $this->faker->lexify($result.'%'),
            'Description' => $this->faker->sentence(),
            'Property' => $this->faker->word(),
            'supplier_id' => $this->faker->randomElement($suppids),
    	];
    }
}
