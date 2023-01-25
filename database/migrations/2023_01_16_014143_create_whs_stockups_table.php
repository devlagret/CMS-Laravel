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
        Schema::create('whs_stockups', function (Blueprint $table) {
            $table->uuid();
            $table->uuid('supplier_id')->nullable()->default('0');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('set null');
            $table->string('product_code');
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('cascade');
            $table->date('purchase_date');
            $table->integer('total_amont');
            $table->integer('quantity');
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
        Schema::dropIfExists('whs_stockups');
    }
};
