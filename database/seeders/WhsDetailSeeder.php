<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WhsDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WhsDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 2; $i++) { 
        $cateids = User::all()->pluck('user_id')->toArray();
        $uid = array_rand($cateids);
        $arr1 = ['?????!!!!','????'];
        $mn = array_rand($arr1);

            WhsDetail::firstOrCreate([
                'warehouse_id' => Str::uuid()->toString(),
                'user_id' => $cateids[$uid],
                'manager_name' => $arr1[$mn],
                'contact' => rand(),
                'adress' => $arr1[$mn],
            ]);
            // dd($cateids);
        }
    }
}
