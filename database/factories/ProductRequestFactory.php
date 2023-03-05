<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\ProductRequest;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductRequestFactory extends Factory
{
    protected $model = ProductRequest::class;

    public function definition(): array
    {
        $wids = Warehouse::all()->pluck('warehouse_id')->toArray();
        $wid = $this->faker->randomElement($wids);
        $pids = Warehouse::where('warehouse_id', $wid)->pluck('product_code')->toArray();
        $pid = $this->faker->randomElement($pids);
        $bids = Branch::all()->pluck('branch_id')->toArray();
        $bid = $this->faker->randomElement($bids);
    	return [
            'request_id' => Str::uuid()->toString(),
            'branch_id' => $bid,
            'product_code' => $pid,
            'warehouse_id' => $wid,
            'amount' => $this->faker->numberBetween(10, 99),
            'order_date' => Carbon::today()->toDateString(),
            'out_date' => '',
            'status' => $this->faker->lexify('pending')
    	];
    }
}
