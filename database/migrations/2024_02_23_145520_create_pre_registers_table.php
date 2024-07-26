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
        Schema::create('pre_registers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('pemohon', ['perorangan', 'perusahaan']);
            $table->enum('jenis_perusahaan', ['cabang', 'induk'])->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('verify_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_registers');
    }
};
