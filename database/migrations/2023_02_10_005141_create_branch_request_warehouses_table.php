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
        Schema::create('branch_request_warehouses', function (Blueprint $table) {
            $table->uuid('warehouse_id')->nullable()->default('0');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('warehouses')->onDelete('set null');
            $table->uuid('request_id')->nullable()->default('0');
            $table->foreign('request_id')->references('request_id')->on('product_requests')->onDelete('set null');
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
        Schema::dropIfExists('branch_request_warehouses');
    }
};
