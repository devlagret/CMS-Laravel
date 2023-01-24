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
            $table->uuid('uid')->primary();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('contact',15);
            $table->string('email');
            $table->string('password')->default('null');
            $table->string('role', 25)->default('user');
            $table->timestamps();
        });
        // Insert some stuff
        DB::table('user')->insert([
            [
                'uid' => Str::uuid()->toString(),
                'username' => 'admin',
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'role' =>'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'uid' => Str::uuid()->toString(),
                'username' => 'admingudang',
                'name' => 'Admin Gudang',
                'password' => Hash::make('admingudang'),
                'role' => 'admingudang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]]
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