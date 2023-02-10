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
        Schema::create('warehouse_response_branches', function (Blueprint $table) {
            $table->uuid('warehouse_response_id')->primary();
            $table->uuid('warehouse_id')->nullable()->default('0');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('warehouses')->onDelete('set null')->onUpdate('cascade');
            $table->uuid('branch_id')->nullable()->default('0');
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('set null')->onUpdate('cascade');
            $table->string('product_code');
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->date('send_date');
            $table->integer('quantity');
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
        Schema::dropIfExists('warehouse_response_branches');
    }
};
