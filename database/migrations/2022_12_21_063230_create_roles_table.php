<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('role_id')->primary();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('roles')->insert(
            [
                [
                    'role_id' => Str::uuid()->toString(),
                    'name' => 'admin',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ], [
                    'role_id' => Str::uuid()->toString(),
                    'name' => 'admingudang',
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
        Schema::dropIfExists('roles');
    }
};
