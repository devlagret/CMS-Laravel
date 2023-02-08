<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uids = User::all()->pluck('user_id')->toArray();
        foreach ($uids as  $id) {
            Branch::factory()->create(['user_id' => $id]);

        }
    }
}
