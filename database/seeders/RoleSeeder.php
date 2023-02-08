<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr1 = ['Branch', 'User'];
        foreach ($arr1 as $name) {
            Role::firstOrCreate([
                'role_id' => Str::uuid()->toString(),
                'name' => $name,
            ]);
        }
    }
}
