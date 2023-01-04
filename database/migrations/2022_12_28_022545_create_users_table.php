<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('username', 50)->unique();
            $table->string('name', 50);
            $table->string('password')->default('null');
            $table->string('role', 25)->default('user');
            $table->timestamps();
        });
        // Insert some stuff
        DB::table('users')->insert(
            array(
                'username' => 'admin',
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'role' =>'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
