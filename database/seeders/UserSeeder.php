<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->first();
        User::firstOrCreate([
            'user_id' => Str::uuid()->toString(),
            'username' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('admin'),
            'contact' => '081222333444555',
            'role_id' => $role->role_id,
            'email' => 'admin@exmple.com',
        ]);
    }
}
