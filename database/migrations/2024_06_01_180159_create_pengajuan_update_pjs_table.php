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
        Schema::create('pengajuan_update_pjs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pj_barantin_id');
            $table->string('keterangan');
            $table->string('update_token')->unique()->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->enum('persetujuan', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu')->nullable();
            $table->enum('status_update', ['proses', 'gagal', 'selesai'])->default('proses')->nullable();
            $table->json('temp_update')->nullable();
            $table->timestamps();
            $table->foreign('pj_barantin_id')->references('id')->on('pj_barantins')->cascadeOnDeleter()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_update_pjs');
    }
};
