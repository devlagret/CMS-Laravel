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
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('branch_id')->primary();
            $table->string('branch_name', 75);
            $table->string('leader_name', 50);
            $table->string('contact', 20);
            $table->string('address', 100);
            $table->uuid('user_id')->nullable()->default('0');
            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('branches');
    }
};
