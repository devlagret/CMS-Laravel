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
            $table->string('alter', 50);
            $table->string('label', 50);
            $table->string('group', 20);
            $table->timestamps();
        });
        // Insert Permisions
        DB::table('permisions')->insert([
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'super-admin',
                'alter' => 'admin',
                'label' => 'Akses Admin',
                'group' => 'DB',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //Profil perusahaan
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-company-profile',
                'alter' => 'lihat-profil-perusahaan',
                'label' => 'Melihat Profil Perusahaan',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-company-profile',
                'alter' => 'tambah-profil-perusahaan',
                'label' => 'Menambahkan Profil Perudahaan Baru',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-company-profile',
                'alter' => 'edit-profil-perusahaan',
                'label' => 'Mengubah Profil Perusahaan',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-company-profile',
                'alter' => 'hapus-profil-perusahaan',
                'label' => 'Menghapus Profil Perusahaan',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //user
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-all-user',
                'alter' => 'lihat-semua-user',
                'label' => 'Melihat Semua Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user',
                'alter' => 'lihat-data-user',
                'label' => 'Melihat Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user',
                'alter' => 'lihat-data-user',
                'label' => 'Menambahkan User Baru',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-user',
                'alter' => 'edit-data-user',
                'label' => 'Mengubah Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user',
                'alter' => 'hapus-data-user',
                'label' => 'Menghapus Data User',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-user',
                'alter' => 'lihat-data-user-terhapus',
                'label' => 'Melihat Data User yang Sudah Dihapus',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-user',
                'alter' => 'memulikan-data-user-terhapus',
                'label' => 'Memulihkan Data User yang Sudah Dihapus',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user-forever',
                'alter' => 'hapus-data-user-selamanya',
                'label' => 'Menghapus Data User Selamanya',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //role
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user-role',
                'alter' => 'lihat-role',
                'label' => 'Melihat Data Role',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user-role',
                'alter' => 'tambah-role',
                'label' => 'Menambahkan Role Baru',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-user-role',
                'alter' => 'edit-role',
                'label' => 'Mengubah Data Role',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user-role',
                'alter' => 'hapus-role',
                'label' => 'Menghapus Data Role',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-role',
                'alter' => 'lihat-data-role-terhapus',
                'label' => 'Melihat Data Role yang Sudah Dihapus',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-role',
                'alter' => 'memulikan-data-role-terhapus',
                'label' => 'Memulihkan Data Role yang Sudah Dihapus',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-role-forever',
                'alter' => 'hapus-data-role-selamanya',
                'label' => 'Menghapus Data Role Selamanya',
                'group' => 'Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //previlege
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user-privilege',
                'alter' => 'lihat-privilege',
                'label' => 'Melihat data perizinan User',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user-privilege',
                'alter' => 'tambah-privilege',
                'label' => 'Menambahkan Hak Istimewa Baru',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-user-privilege',
                'alter' => 'edit-privilege',
                'label' => 'Mengubah Data Hak Istimewa',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-user-privilege',
                'alter' => 'hapus-privilege',
                'label' => 'Menghapus Data Hak Istimewa',
                'group' => 'Hak Istimewa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //permision
            /*[
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-user-permision',
                'alter' => 'lihat-perizinan-user',
                'label' => 'Melihat Data Perizinan User',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-permision',
                'alter' => 'lihat-perizinan',
                'label' => 'Melihat semua Data Perizinan',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-permision',
                'alter' => 'tambah-perizinan',
                'label' => 'Menambahkan Perizinan Baru',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-permision',
                'alter' => 'edit-perizinan',
                'label' => 'Mengubah Data Perizinan',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-permision',
                'alter' => 'hapus-perizinan',
                'label' => 'Menghapus Data Perizinan',
                'group' => 'Perizinan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],*/
            //product
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product',
                'alter' => 'lihat-produk',
                'label' => 'Melihat Data Produk',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product',
                'alter' => 'tambah-produk',
                'label' => 'Menambahkan Produk Baru',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product',
                'alter' => 'edit-produk',
                'label' => 'Mengubah Data Produk',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product',
                'alter' => 'hapus-produk',
                'label' => 'Menghapus Data Produk',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-product',
                'alter' => 'lihat-data-produk-terhapus',
                'label' => 'Melihat Data Produk yang Sudah Dihapus',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-product',
                'alter' => 'memulikan-data-produk-terhapus',
                'label' => 'Memulihkan Data Produk yang Sudah Dihapus',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-forever',
                'alter' => 'hapus-data-produk-selamanya',
                'label' => 'Menghapus Data Produk Selamanya',
                'group' => 'Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //category
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-category',
                'alter' => 'lihat-kategori',
                'label' => 'Melihat Data Kategori',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-category',
                'alter' => 'tambah-kategori',
                'label' => 'Menambahkan Kategori Baru',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-category',
                'alter' => 'edit-kategori',
                'label' => 'Mengubah Data Kategori',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-category',
                'alter' => 'hapus-kategori',
                'label' => 'Menghapus Data Kategori',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-category',
                'alter' => 'lihat-data-kategori-terhapus',
                'label' => 'Melihat Data Kategori yang Sudah Dihapus',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-category',
                'alter' => 'memulikan-data-kategori-terhapus',
                'label' => 'Memulihkan Data Kategori yang Sudah Dihapus',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-category-forever',
                'alter' => 'hapus-data-kategori-selamanya',
                'label' => 'Menghapus Data Kategori Selamanya',
                'group' => 'Kategori',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //supplier
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-supplier',
                'alter' => 'lihat-supplier',
                'label' => 'Melihat Data Supplier',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-supplier',
                'alter' => 'tambah-supplier',
                'label' => 'Menambahkan Supplier Baru',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-supplier',
                'alter' => 'edit-supplier',
                'label' => 'Mengubah Data Supplier',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-supplier',
                'alter' => 'hapus-supplier',
                'label' => 'Menghapus Data Supplier',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-supplier',
                'alter' => 'lihat-data-supplier-terhapus',
                'label' => 'Melihat Data Supplier yang Sudah Dihapus',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-supplier',
                'alter' => 'memulikan-data-supplier-terhapus',
                'label' => 'Memulihkan Data Supplier yang Sudah Dihapus',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-supplier-forever',
                'alter' => 'hapus-data-supplier-selamanya',
                'label' => 'Menghapus Data Supplier Selamanya',
                'group' => 'Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //branch
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-branch',
                'label' => 'Melihat Data Cabang',
                'alter' => 'lihat-cabang',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-branch',
                'alter' => 'tambah-cabang',
                'label' => 'Menambahkan Cabang Baru',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-branch',
                'alter' => 'edit-cabang',
                'label' => 'Mengubah Data Cabang',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-branch',
                'alter' => 'hapus-cabang',
                'label' => 'Menghapus Data Cabang',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-branch',
                'alter' => 'lihat-data-cabang-terhapus',
                'label' => 'Melihat Data Cabang yang Sudah Dihapus',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-branch',
                'alter' => 'memulikan-data-cabang-terhapus',
                'label' => 'Memulihkan Data Cabang yang Sudah Dihapus',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-branch-forever',
                'alter' => 'hapus-data-cabang-selamanya',
                'label' => 'Menghapus Data Cabang Selamanya',
                'group' => 'Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //warehouse
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-warehouse',
                'alter' => 'lihat-gudang',
                'label' => 'Melihat Data Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-warehouse',
                'alter' => 'tambah-gudang',
                'label' => 'Menambahkan Gudang Baru',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-warehouse',
                'alter' => 'edit-gudang',
                'label' => 'Mengubah Data Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-warehouse',
                'alter' => 'hapus-gudang',
                'label' => 'Menghapus Data Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-warehouse',
                'alter' => 'lihat-data-gudang-terhapus',
                'label' => 'Melihat Data Gudang yang Sudah Dihapus',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-warehouse',
                'alter' => 'memulikan-data-gudang-terhapus',
                'label' => 'Memulihkan Data Gudang yang Sudah Dihapus',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-warehouse-forever',
                'alter' => 'hapus-data-gudang-selamanya',
                'label' => 'Menghapus Data Gudang Selamanya',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //warehouse detail
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-detail-warehouse',
                'alter' => 'lihat-detail-gudang',
                'label' => 'Melihat Profil Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-detail-warehouse',
                'alter' => 'edit-detail-gudang',
                'label' => 'Mengubah Profil Gudang',
                'group' => 'Gudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], 
            //order produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-order',
                'alter' => 'lihat-pesanan',
                'label' => 'Melihat Data Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-order',
                'alter' => 'tambah-pesanan',
                'label' => 'Merespon Request Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-order',
                'alter' => 'edit-pesanan',
                'label' => 'Mengubah Data Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-order',
                'alter' => 'hapus-pesanan',
                'label' => 'Menghapus Data Order',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-product-order',
                'alter' => 'lihat-pesanan-terhapus',
                'label' => 'Melihat Data Order yang Sudah Dihapus',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-product-order',
                'alter' => 'memulikan-pesanan-terhapus',
                'label' => 'Memulihkan Data Order yang Sudah Dihapus',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-order-forever',
                'alter' => 'hapus-pesanan-selamanya',
                'label' => 'Menghapus Data Order Selamanya',
                'group' => 'Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
             //request order produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-order-request',
                'alter' => 'lihat-request-pesanan',
                'label' => 'Melihat Data Request Order',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-order-request',
                'alter' => 'tambah-request-pesanan',
                'label' => 'Menambahkan Request Order Baru',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-order-request',
                'alter' => 'edit-request-pesanan',
                'label' => 'Mengubah Data Request Order',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-order-request',
                'alter' => 'hapus-request-pesanan',
                'label' => 'Menghapus Data Request Order',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-product-order-request',
                'alter' => 'lihat-request-pesanan-terhapus',
                'label' => 'Melihat Data Request Order yang Sudah Dihapus',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-product-order-request',
                'alter' => 'memulikan-request-pesanan',
                'label' => 'Memulihkan Data Request Order yang Sudah Dihapus',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-order-request-forever',
                'alter' => 'hapus-request-pesanana',
                'label' => 'Menghapus Data Request Order Selamanya',
                'group' => 'Request Order',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //request produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-request',
                'alter' => 'lihat-request-produk',
                'label' => 'Melihat Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-request',
                'alter' => 'tambah-request-produk',
                'label' => 'Menambahkan Request Produk Baru',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-request',
                'alter' => 'edit-request-produk',
                'label' => 'Mengubah Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-request',
                'alter' => 'hapus-request-produk',
                'label' => 'Menghapus Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-product-request',
                'alter' => 'lihat-request-produk-terhapus',
                'label' => 'Melihat Data Request Produk yang Sudah Dihapus',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-product-request',
                'alter' => 'memulikan-request-produk-terhapus',
                'label' => 'Memulihkan Data Request Produk yang Sudah Dihapus',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-request-forever',
                'alter' => 'hapus-request-produk-selamanya',
                'label' => 'Menghapus Data Request Produk Selamanya',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            //respons request produk
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-product-request-response',
                'alter' => 'lihat-respon-request-produk',
                'label' => 'Melihat Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-product-request-response',
                'alter' => 'tambah-respon-request-produk',
                'label' => 'Merespon Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'edit-product-request-response',
                'alter' => 'edit-respon-request-produk',
                'label' => 'Mengubah Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-request-response',
                'alter' => 'hapus-respon-request-produk',
                'label' => 'Menghapus Data Request Produk',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'view-deleted-product-request-response',
                'alter' => 'lihat-respon-request-produk-terhapus',
                'label' => 'Melihat Data Request Produk yang Sudah Dihapus',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'restore-deleted-product-request-response',
                'alter' => 'memulikan-respon-request-produk-terhapus',
                'label' => 'Memulihkan Data Request Produk yang Sudah Dihapus',
                'group' => 'Request Produk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'delete-product-request-response-forever',
                'alter' => 'hapus-respon-request-produk-selamanya',
                'label' => 'Menghapus Data Request Produk Selamanya',
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
