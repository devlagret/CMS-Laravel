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
        Schema::create('request_orders', function (Blueprint $table) {
            $table->uuid('product_order_id');
            $table->foreign('product_order_id')->references('product_order_id')->on('product_order')->onDelete('cascade');
            $table->uuid('product_order_requests_id')->nullable()->default(null);
            $table->foreign('product_order_requests_id')->references('product_order_requests_id')->on('product_order_requests')->onDelete('cascade');
            $table->uuid('warehouse_id');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('warehouses')->onDelete('cascade');
            $table->integer('quantity')->unsigned();
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
        Schema::dropIfExists('request_orders');
    }
};
