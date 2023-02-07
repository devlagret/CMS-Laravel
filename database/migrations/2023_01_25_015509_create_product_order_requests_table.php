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
        Schema::create('product_order_requests', function (Blueprint $table) {
            $table->uuid('product_order_requests_id')->primary();
            $table->uuid('warehouse_id')->nullable()->default(null);
            $table->foreign('warehouse_id')->references('warehouse_id')->on('whs_detail')->onDelete('set null')->onUpdate('cascade');
            $table->string('product_code', 50);
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('restrict')->onUpdate('cascade');
            $table->date('request_date');
            $table->integer('quantity');
            $table->enum('status', ['sent', 'accepted', 'transferred']);
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
        Schema::dropIfExists('product_order_requests');
    }
};
