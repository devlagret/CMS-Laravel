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
        Schema::create('response_orders', function (Blueprint $table) {
            $table->uuid('response_id')->primary();
            $table->uuid('product_order_id')->nullable()->default('0');
            $table->foreign('product_order_id')->references('product_order_id')->on('product_order')->onDelete('set null');
            $table->uuid('product_order_requests_id')->nullable();
            $table->foreign('product_order_requests_id')->references('product_order_requests_id')->on('product_order_requests')->onDelete('set null');
            $table->uuid('warehouse_id')->nullable()->default('0');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('warehouses')->onDelete('set null');
            $table->integer('quantity')->unsigned();
            $table->enum('is_received', ['On Road', 'Accepted', 'Finished']);
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
        Schema::dropIfExists('response_orders');
    }
};
