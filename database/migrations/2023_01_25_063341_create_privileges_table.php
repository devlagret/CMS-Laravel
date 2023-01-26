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
        Schema::create('privileges', function (Blueprint $table) {
            //$table->uuid('previlige_id');
            $table->uuid('permision_id');
            $table->foreign('permision_id')->references('permision_id')->on('permisions')->onDelete('restrict')->onUpdate('restrict');
            $table->uuid('role_id');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
        // Insert Default Previleges
        $role = DB::table('roles')->where('name', 'admin')->first();
        $permision = DB::table('permisions')->where('label','Akses Admin')->first();
        DB::table('privileges')->insert([
            'permision_id' => $permision->permision_id,
            'role_id' => $role->role_id,
        ]);
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   

    public function down()
    {
        Schema::dropIfExists('privileges');
    }
};
