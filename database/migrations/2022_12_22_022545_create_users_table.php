<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('contact', 15);
            $table->string('email');
            $table->string('password')->default('null');
            $table->uuid('role_id')->nullable()->default('user');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
        //get admin role
       $role = DB::table('roles')->where('name', 'admin')->first();
       $role2 = DB::table('roles')->where('name', 'admingudang')->first();
        // Insert default user
        DB::table('user')->insert(
            [
                [
                    'user_id' => Str::uuid()->toString(),
                    'username' => 'admin',
                    'name' => 'Admin',
                    'password' => Hash::make('admin'),
                    'contact' => '081222333444555',
                    'role_id' => $role->role_id,
                    'email' => 'admin@exmple.com',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'user_id' => Str::uuid()->toString(),
                    'username' => 'admingudang',
                    'name' => 'Admin Gudang',
                    'contact' => '081222333444556',
                    'email' => 'admingudang@exmple.com',
                    'role_id' => $role2->role_id,
                    'password' => Hash::make('admingudang'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
