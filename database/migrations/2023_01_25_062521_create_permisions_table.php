<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisions', function (Blueprint $table) {
            $table->uuid('permision_id')->primary();
            $table->string('name',50);
            $table->string('label',50);
            $table->string('group',20);
            $table->timestamps();
        });
        // Insert Permisions
        DB::table('permisions')->insert([
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'super-admin',
                'label' => 'Akses Admin',
                'group' => 'DB',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'permision_id' => Str::uuid()->toString(),
                'name' => 'add-user',
                'label' => 'Menambahkan User Baru',
                'group' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
 
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisions');
    }
};
