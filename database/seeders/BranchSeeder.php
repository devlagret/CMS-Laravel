<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use App\Models\WhsDetail;
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
        $rid = Role::where('name', 'branch')->first('role_id');
        $uids = User::where('role_id', $rid->role_id)->pluck('user_id')->toArray();
        $wids = WhsDetail::pluck('warehouse_id')->toArray();
        $rk = array_rand($wids);
        foreach ($uids as  $id) {
            Branch::factory()->create(['user_id' => $id, 'warehouse_id' => $wids[$rk]]);
        }
    }
}
