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
            $table->uuid('request_id')->primary();
            $table->uuid('branch_id')->nullable()->default('0');
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null')->onUpdate('cascade');
            $table->string('product_code', 50)->nullable()->default('0');
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('set null')->onUpdate('cascade');
            $table->uuid('warehouse_id')->nullable()->default('0');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('warehouses')->onDelete('set null')->onUpdate('cascade');
            $table->integer('amount');
            $table->dateTime('order_date');
            $table->dateTime('out_date')->nullable();
            $table->enum('status', ['pending', 'accepted', 'transferred', 'rejected', 'finished']);
            $table->timestamps();
            $table->softDeletes();
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
