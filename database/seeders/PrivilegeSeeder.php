<?php

namespace Database\Seeders;

use App\Models\Permision;
use App\Models\Privilege;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admingudang')->first();
        $permision = Permision::whereIn('label',['Melihat Profil Gudang', 'Melihat Data Request Order', 'Melihat Data Gudang'])->get();
        foreach ($permision as $p) {
            Privilege::create([
                //'previlige_id' => Str::uuid(),
                'permision_id' => $p->permision_id,
                'role_id' => $role->role_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
