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
        $role1 = Role::whereIn('name', ['branch', 'user', 'admingudang'])->get();
        foreach ($role1 as $role) {
            if ($role->name == 'branch') {
                for ($i=0; $i < 4; $i++) { 
                    User::firstOrCreate([
                        'user_id' => Str::uuid()->toString(),
                        'username' => 'branch'.$i+1,
                        'name' => 'Branch',
                        'password' => Hash::make('branch'.$i+1),
                        'contact' => '081222333444555',
                        'role_id' => $role->role_id,
                        'email' => 'branch@exmple.com',
                    ]);
                }
            } elseif ($role->name == 'user') {
                User::firstOrCreate([
                    'user_id' => Str::uuid()->toString(),
                    'username' => 'user',
                    'name' => 'User',
                    'password' => Hash::make('user'),
                    'contact' => '081222333444555',
                    'role_id' => $role->role_id,
                    'email' => 'user@exmple.com',
                ]);
            } elseif ($role->name == 'admingudang') {
                User::firstOrCreate([
                    'user_id' => Str::uuid()->toString(),
                    'username' => 'admingudang2',
                    'name' => 'Admingudang2',
                    'password' => Hash::make('admingudang2'),
                    'contact' => '081222333444555',
                    'role_id' => $role->role_id,
                    'email' => 'admingudang2@exmple.com',
                ]);
            }
        }
    }
}
