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
        Schema::create('ppjks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pj_barantin_id')->nullable();

            $table->enum('jenis_perusahaan', ['PEMILIK BARANG', 'PPJK', 'EMKL', 'EMKU', 'LAINNYA'])->nullable()->default('PPJK');
            $table->string('nama_ppjk')->nullable();
            $table->string('email_ppjk')->nullable();
            $table->date('tanggal_kerjasama_ppjk')->nullable();
            $table->string('alamat_ppjk')->nullable();

            $table->bigInteger('master_negara_id')->unsigned()->nullable();
            $table->bigInteger('master_provinsi_id')->unsigned()->nullable();
            $table->bigInteger('master_kota_kab_id')->unsigned()->nullable();

            $table->string('nama_cp_ppjk')->nullable();
            $table->string('alamat_cp_ppjk')->nullable();
            $table->string('telepon_cp_ppjk')->nullable();

            $table->string('nama_tdd_ppjk')->nullable();
            $table->string('jenis_identitas_tdd_ppjk')->nullable();
            $table->string('nomor_identitas_tdd_ppjk')->nullable();
            $table->string('jabatan_tdd_ppjk')->nullable();
            $table->string('alamat_tdd_ppjk')->nullable();
            $table->enum('status_ppjk', ['AKTIF', 'NONAKTIF'])->nullable()->default('NONAKTIF');

            $table->foreign('pj_barantin_id')->references('id')->on('pj_barantins')->cascadeOnDeleter()->cascadeOnUpdate();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppjks');
    }
};
