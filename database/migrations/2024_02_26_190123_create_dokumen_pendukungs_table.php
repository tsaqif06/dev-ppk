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
        Schema::create('dokumen_pendukungs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pj_barantin_id')->nullable();
            $table->uuid('pre_register_id')->nullable();
            $table->string('jenis_dokumen');
            $table->string('nomer_dokumen');
            $table->date('tanggal_terbit');
            $table->string('file');
            $table->foreign('pj_barantin_id')->references('id')->on('pj_barantins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('pre_register_id')->references('id')->on('pre_registers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pendukungs');
    }
};
