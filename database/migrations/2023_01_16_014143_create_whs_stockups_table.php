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
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable()->default(12);
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->json('items');
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
