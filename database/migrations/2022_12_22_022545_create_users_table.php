<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $table->string('password')->nullable();
            $table->string('role', 25)->default('user');
            $table->timestamps();
        });
        // Insert some stuff
        DB::table('user')->insert(
            [
                [
                    'user_id' => Str::uuid()->toString(),
                    'username' => 'admin',
                    'name' => 'Admin',
                    'password' => Hash::make('admin'),
                    'contact' => '081222333444555',
                    'email' => 'admin@exmple.com',
                    'role' => 'admin',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'user_id' => Str::uuid()->toString(),
                    'username' => 'admingudang',
                    'name' => 'Admin Gudang',
                    'contact' => '081222333444556',
                    'email' => 'admingudang@exmple.com',
                    'password' => Hash::make('admingudang'),
                    'role' => 'admingudang',
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
