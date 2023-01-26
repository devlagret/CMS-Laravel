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
        Schema::create('whs_detail', function (Blueprint $table) {
            $table->uuid('warehouse_id')->primary();
            $table->uuid('user_id')->nullable()->default('0');
            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('set null')->onUpdate('cascade');
            $table->string('manager_name',50);
            $table->string('contact', 50);
            $table->string('adress', 50);
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
        Schema::dropIfExists('whs_detail');
    }
};
