<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
