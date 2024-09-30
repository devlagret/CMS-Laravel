<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->create([
        //     [
        //         'user_id' => Str::uuid()->toString(),
        //         'username' => 'admin',
        //         'name' => 'Admin',
        //         'password' => Hash::make('admin'),
        //         'contact' => '081222333444555',
        //         'role_id' => $role->role_id,
        //         'email' => 'admin@exmple.com',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ], [
        //         'user_id' => Str::uuid()->toString(),
        //         'username' => 'admingudang',
        //         'name' => 'Admin Gudang',
        //         'contact' => '081222333444556',
        //         'email' => 'admingudang@exmple.com',
        //         'role_id' => $role2->role_id,
        //         'password' => Hash::make('admingudang'),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // ]);
        $this->call([
            // UserSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            RoleSeeder::class,
            PrivilegeSeeder::class,
            WhsDetailSeeder::class,
            BranchSeeder::class,
            WarehouseSeeder::class,
            ProductOrderRequestSeeder::class,
        ]);
    }
}
