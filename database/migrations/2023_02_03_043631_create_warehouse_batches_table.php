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
        Schema::create('warehouse_batches', function (Blueprint $table) {
            $table->unsignedBigInteger('warehouse_id')->nullable()->default('0');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
            $table->uuid('batch_id')->nullable()->default('0');
            $table->foreign('batch_id')->references('batch_id')->on('batches')->onDelete('set null');
            $table->uuid('product_id')->nullable()->default('0');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->integer('quantity');
            $table->date('expired_date');
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
        Schema::dropIfExists('warehouse_batches');
    }
};
