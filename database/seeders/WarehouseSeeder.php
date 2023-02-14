<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WhsDetail;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $whsids = WhsDetail::all()->pluck('warehouse_id')->toArray();
            $wid = array_rand($whsids);
            $pids = Product::all()->pluck('product_code')->toArray();
            $pid = array_rand($pids);
            $arr1 = ['Surakarta', 'Karanganyar'];
            $l = array_rand($arr1);
            $id = Warehouse::orderBy('id', 'DESC')->first();

            Warehouse::firstOrCreate([
                'warehouse_id' => $whsids[$wid],
                'product_code' => $pids[$pid],
                'stock' => rand(10,100),
                'location' => $arr1[$l],
                'entry_date' => Carbon::today()->toDateString(),
            ]);
        }
    }
}
