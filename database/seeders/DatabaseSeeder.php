<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WhsDetailSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            WarehouseSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PrivilegeSeeder::class,
            ProductOrderRequestSeeder::class,
            BranchSeeder::class,
        ]);
    }
}
