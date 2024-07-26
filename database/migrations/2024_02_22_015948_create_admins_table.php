<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('uid');
            $table->string('uname');
            $table->string('nama');
            $table->string('email');
            $table->string('upt_id')->nullable();
            $table->string('roles_id');
            $table->string('apps_id');
            $table->string('role_name');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->string('password');
            $table->timestamp('expiry');
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
