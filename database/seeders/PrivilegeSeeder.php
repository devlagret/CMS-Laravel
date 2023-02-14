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
        $role = Role::whereIn('name', ['admingudang', 'branch', 'user'])->get();
        foreach ($role as $role) {
            if ($role->name == 'branch'){
                $permision = Permision::whereIn('label',[
                    'Melihat Data Cabang', 'Mengubah Data Cabang', 'Menghapus Data Cabang', 'Menambahkan Cabang Baru','Melihat Data Gudang', 'Melihat Profil Gudang', 'Melihat Data Produk', 'Mengubah Data Request Produk', 'Menghapus Data Request Produk', 'Mengubah Data Request Produk', 'Menambahkan Request Produk Baru'])->get();
                foreach ($permision as $p) {
                    Privilege::create([
                        //'previlige_id' => Str::uuid(),
                        'permision_id' => $p->permision_id,
                        'role_id' => $role->role_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }elseif ($role->name == 'user'){
                $permision = Permision::whereIn('label',[
                    'Melihat Profil Perusahaan', 'Melihat Data User'])->get();
                foreach ($permision as $p) {
                    Privilege::create([
                        //'previlige_id' => Str::uuid(),
                        'permision_id' => $p->permision_id,
                        'role_id' => $role->role_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }elseif ($role->name == 'admingudang'){
                $permision = Permision::whereIn('group',['gudang', 'Request Order'])
                                      ->orWhereIn('name',['view-product', 'edit-product', 'add-product', 'view-product-category', 'view-supplier', 'view-product-request'])
                                      ->get();
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
    }
}
