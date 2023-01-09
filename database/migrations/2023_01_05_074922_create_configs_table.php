<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->string('key',50)->primary();
            $table->string('type', 10);
            $table->string('value',100);
        });
        // Insert some stuff
        DB::table('configs')->insert([
            ['type'=>'profile', 'key' => 'name', 'value'=>'PT. Terbang ke Angkasa'],
            ['type'=>'profile', 'key' => 'leader', 'value'=> 'Hubert Blaine Wolfeschlegelsteinhausenbergerdorff Sr.'],
            ['type'=>'profile', 'key' => 'adress', 'value'=>'Jl Maju Jaya Abadi Putra Candra Cahya Prima Santosa '],
            ['type'=>'profile', 'key' => 'contact', 'value'=>'081234567890'],
            ['type'=>'profile', 'key' => 'email', 'value'=>'terbangt@akasa.gemail.com'],
        ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
};
