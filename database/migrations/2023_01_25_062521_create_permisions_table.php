<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisions', function (Blueprint $table) {
            $table->uuid('permision_id')->primary();
            $table->string('name', 50);
            $table->string('label', 50);
            $table->string('group', 20);
            $table->timestamps();
        });
        // Insert Permisions
        DB::table('permisions')->insert([
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'super-admin',
                'label' => 'Akses Admin',
                'group' => 'DB',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //Profil perusahaan
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-company-profile',
                'label' => 'Melihat Profil Perusahaan',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-company-profile',
                'label' => 'Menambahkan Profil Perudahaan Baru',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-company-profile',
                'label' => 'Mengubah Profil Perusahaan',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-company-profile',
                'label' => 'Menghapus Profil Perusahaan',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //user
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-all-user',
                'label' => 'Melihat Semua Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user',
                'label' => 'Melihat Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user',
                'label' => 'Menambahkan User Baru',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-user',
                'label' => 'Mengubah Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user',
                'label' => 'Menghapus Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //role
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user-role',
                'label' => 'Melihat Data Role',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user-role',
                'label' => 'Menambahkan Role Baru',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-user-role',
                'label' => 'Mengubah Data Role',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user-role',
                'label' => 'Menghapus Data Role',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //previlege
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user-privilege',
                'label' => 'Melihat data perizinan User',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user-privilege',
                'label' => 'Menambahkan Hak Istimewa Baru',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-user-privilege',
                'label' => 'Mengubah Data Hak Istimewa',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user-privilege',
                'label' => 'Menghapus Data Hak Istimewa',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //permision
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user-permision',
                'label' => 'Melihat Data Perizinan User',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-permision',
                'label' => 'Melihat semua Data Perizinan',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-permision',
                'label' => 'Menambahkan Perizinan Baru',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-permision',
                'label' => 'Mengubah Data Perizinan',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-permision',
                'label' => 'Menghapus Data Perizinan',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //product
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product',
                'label' => 'Melihat Data Produk',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product',
                'label' => 'Menambahkan Produk Baru',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product',
                'label' => 'Mengubah Data Produk',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product',
                'label' => 'Menghapus Data Produk',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //category
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-category',
                'label' => 'Melihat Data Kategori',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-category',
                'label' => 'Menambahkan Kategori Baru',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-category',
                'label' => 'Mengubah Data Kategori',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-category',
                'label' => 'Menghapus Data Kategori',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //supplier
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-supplier',
                'label' => 'Melihat Data Supplier',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-supplier',
                'label' => 'Menambahkan Supplier Baru',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-supplier',
                'label' => 'Mengubah Data Supplier',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-supplier',
                'label' => 'Menghapus Data Supplier',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //branch
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-branch',
                'label' => 'Melihat Data Cabang',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-branch',
                'label' => 'Menambahkan Cabang Baru',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-branch',
                'label' => 'Mengubah Data Cabang',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-branch',
                'label' => 'Menghapus Data Cabang',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //warehouse
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-warehouse',
                'label' => 'Melihat Data Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-warehouse',
                'label' => 'Menambahkan Gudang Baru',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-warehouse',
                'label' => 'Mengubah Data Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-warehouse',
                'label' => 'Menghapus Data Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //warehouse detail
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-detail-warehouse',
                'label' => 'Melihat Profil Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-detail-warehouse',
                'label' => 'Menambahkan Profil Gudang Baru',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-detail-warehouse',
                'label' => 'Mengubah Profil Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-detail-warehouse',
                'label' => 'Menghapus Profil Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], 
            //order produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-order',
                'label' => 'Melihat Data Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-order',
                'label' => 'Merespon Request Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-order',
                'label' => 'Mengubah Data Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-order',
                'label' => 'Menghapus Data Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
             //request order produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-order-request',
                'label' => 'Melihat Data Request Order',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-order-request',
                'label' => 'Menambahkan Request Order Baru',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-order-request',
                'label' => 'Mengubah Data Request Order',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-order-request',
                'label' => 'Menghapus Data Request Order',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //request produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-request',
                'label' => 'Melihat Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-request',
                'label' => 'Menambahkan Request Produk Baru',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-request',
                'label' => 'Mengubah Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-request',
                'label' => 'Menghapus Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //respons request produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-request-response',
                'label' => 'Melihat Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-request-response',
                'label' => 'Merespon Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-request-response',
                'label' => 'Mengubah Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-request-response',
                'label' => 'Menghapus Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisions');
    }
};
