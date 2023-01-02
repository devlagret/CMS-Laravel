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
            $table->string('product_id',50);
            $table->string('product_code',50)->unique();
            $table->string('brand',50);
            $table->string('name',100);
            $table->unsignedBigInteger('category_id')->nullable()->default('0');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('set null')->onUpdate('cascade');
            $table->string('buy_price',20);
            $table->string('price_rec',20);
            $table->string('Profit_Margin',5);
            $table->dateTime('Entry_Date',0);
            $table->dateTime('Out_Date',0);
            $table->date('Expiration_Date');
            $table->string('Description');
            $table->string('Property');
            $table->unsignedBigInteger('supplier_id')->nullable()->default('0');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('set null')->onUpdate('cascade');
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
