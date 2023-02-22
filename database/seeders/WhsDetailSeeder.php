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
        $uids = User::where('role_id', $role->role_id)->pluck('user_id')->toArray();
        // ->orWhere('role_id', $role1->role_id)
        $i = 0;
        $arr1 = ['barat','timur','utara','selatan'];
        foreach ($uids as  $uid) {
            
    
                WhsDetail::firstOrCreate([
                    'warehouse_id' => Str::uuid()->toString(),
                    'user_id' => $uid,
                    'name' => 'warehouse '.$arr1[$i],
                    'manager_name' => 'Budi '.$i,
                    'contact' => rand(),
                    'adress' => $arr1[$i],
                ]);
                $i++;
        }
        // $uid = array_rand($cateids);
            // dd($cateids);
        }
}
