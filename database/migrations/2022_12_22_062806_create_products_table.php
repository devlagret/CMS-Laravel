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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('Product_Code');
            $table->string('Brand');
            $table->string('Name');
            $table->string('type');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->string('buy_price');
            $table->string('Price_Recomendation_from_Sup');
            $table->string('Price_Recomendation');
            $table->string('Profit_Margin');
            $table->string('Entry_Date');
            $table->string('Out_Date');
            $table->string('Expiration_Date');
            $table->string('Description');
            $table->string('Property');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers');
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
