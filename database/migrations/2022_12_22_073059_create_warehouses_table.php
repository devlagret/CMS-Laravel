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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('warehouse_id')->nullable()->default('0');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('whs_detail')->onDelete('set null')->onUpdate('cascade');
            $table->string('product_code', 50)->nullable()->default('0');
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('set null')->onUpdate('cascade');
            $table->integer('stock');
            $table->string('location', 50)->nullable();
            $table->date('entry_date');
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
        Schema::dropIfExists('warehouses');
    }
};
