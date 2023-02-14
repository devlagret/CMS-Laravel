<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $role = Role::where('name', 'admingudang')->first('role_id');
        $role1 = Role::where('name', 'admin')->first('role_id');
        $uids = User::where('role_id', $role->role_id)
        // ->orWhere('role_id', $role1->role_id)
        ->pluck('user_id')->toArray();
        foreach ($uids as  $uid) {
            $arr1 = '?????!!!!';
    
                WhsDetail::firstOrCreate([
                    'warehouse_id' => Str::uuid()->toString(),
                    'user_id' => $uid,
                    'manager_name' => $arr1,
                    'contact' => rand(),
                    'adress' => $arr1,
                ]);
        }
        // $uid = array_rand($cateids);
            // dd($cateids);
        }
}
