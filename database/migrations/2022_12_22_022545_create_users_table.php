<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', callback: function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('full_name', 250)->nullable();
            $table->string('contact', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('password')->invinsible()->default('null');
            $table->uuid('role_id')->nullable();
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('set null')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->integer('deleted_id')->nullable();
            $table->decimal('user_level', 1, 0)->default(0);
            $table->string('user_token', 250)->nullable();
            $table->text('adrress')->nullable();
            $table->text('avatar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        //get admin role
        $role = DB::table('roles')->where('name', 'admin')->first();
        $role2 = DB::table('roles')->where('name', 'admingudang')->first();
        // Insert default user
        User::create(
            [
                'uuid' => Str::uuid()->toString(),
                'username' => 'admin',
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'contact' => '081222333444555',
                'role_id' => $role->role_id,
                'email' => 'admin@exmple.com',
            ]
        );
        User::create(
            [
                'uuid' => Str::uuid()->toString(),
                'username' => 'admingudang',
                'name' => 'Admin Gudang',
                'contact' => '081222333444556',
                'email' => 'admingudang@exmple.com',
                'role_id' => $role2->role_id,
                'password' => Hash::make('admingudang'),
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
        Schema::dropIfExists('user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
