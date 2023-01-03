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
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null')->onUpdate('cascade');
            $table->string('product_code', 50)->nullable();
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('set null')->onUpdate('cascade');
            $table->integer('amount');
            $table->dateTime('order_date');
            $table->dateTime('out_date')->nullable();
            $table->string('status',10);
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
        Schema::dropIfExists('product_requests');
    }
};
