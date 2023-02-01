<?php

namespace Database\Factories;

use App\Model;
use App\Models\ProductOrderRequest;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductOrderRequestFactory extends Factory
{
    protected $model = ProductOrderRequest::class;

    public function definition(): array
    {
        $wids = Warehouse::all()->pluck('warehouse_id')->toArray();
        $wid = $this->faker->randomElement($wids);
        $pids = Warehouse::all()->pluck('product_code')->toArray();
        $pid = $this->faker->randomElement($pids);

    	return [
    	    'product_order_requests_id' => Str::uuid()->toString(),
            'warehouse_id' => $wid,
            'product_code' =>  $pid,
            'request_date' => Carbon::today()->toDateString(),
            'quantity' => $this->faker->numberBetween(10, 99),
            'status' => $this->faker->lexify('sent')
    	];
    }
}
