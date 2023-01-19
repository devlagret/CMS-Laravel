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
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('product_id',50)->nullable();
            $table->string('product_code',50)->unique();
            $table->string('brand',50)->nullable();
            $table->string('name',100);
            $table->unsignedBigInteger('category_id')->nullable()->default('0');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
            $table->string('buy_price',20);
            $table->string('price_rec',20);
            $table->string('price_rec_from_sup', 20)->nullable();
            $table->string('profit_margin',5);
            $table->string('description')->nullable();
            $table->string('property')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable()->default('0');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('products');
    }
};
