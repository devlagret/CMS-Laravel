<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $cateids = Category::all()->pluck('category_id')->toArray();
        $suppids = Supplier::all()->pluck('supplier_id')->toArray();
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
            'id' => $this->faker->uuid(),
            'product_id' => $this->faker->regexify('[A-Z]{2}-[0-9]{3}'),
    	      'product_code' => $this->faker->ean13(),
            'brand' => $this->faker->company(),
            'name' => $this->faker->name(),
            'category_id' => $this->faker->randomElement($cateids),
            'buy_price' => $this->faker->numerify($buy),
            'price_rec' => $this->faker->numerify($price),
            'price_rec_from_sup' => $this->faker->numerify($price_rec),
            'profit_margin' => $this->faker->lexify($result.'%'),
            'description' => $this->faker->sentence(),
            'property' => $this->faker->word(),
            'supplier_id' => $this->faker->randomElement($suppids),
    	];
    }
}
