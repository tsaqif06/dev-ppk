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
        Schema::create('pj_barantins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pre_register_id');
            $table->uuid('user_id')->nullable();
            $table->string('kode_perusahaan')->nullable();
            $table->string('password')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_alias_perusahaan')->nullable();
            $table->enum('jenis_identitas', ['KTP', 'PASSPORT', 'NPWP'])->nullable();
            $table->string('nomor_identitas')->nullable();
            $table->string('nitku')->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('kota')->nullable();
            $table->string('telepon')->nullable();
            $table->string('nama_cp')->nullable();
            $table->string('alamat_cp')->nullable();
            $table->string('telepon_cp')->nullable();
            $table->string('nama_tdd')->nullable();
            $table->enum('jenis_identitas_tdd', ['KTP', 'PASSPORT', 'NPWP'])->nullable();
            $table->string('nomor_identitas_tdd')->nullable();
            $table->string('jabatan_tdd')->nullable();
            $table->string('alamat_tdd')->nullable();
            $table->string('nama_pendaftar')->nullable();
            $table->string('ktp_pendaftar')->nullable();
            $table->enum('jenis_perusahaan', ['PEMILIK BARANG', 'PPJK', 'EMKL', 'EMKU', 'LAINNYA'])->nullable();
            $table->string('kontak_ppjk')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->unsignedBigInteger('status_import')->nullable();
            $table->string('lingkup_aktifitas')->nullable();
            $table->unsignedBigInteger('negara_id')->nullable();
            $table->tinyInteger('is_active')->unsigned()->default(1);
            $table->tinyInteger('status_prioritas')->default(0)->comment('1: layanan prioritas; 5: draft ekspor');
            $table->foreign('pre_register_id')->references('id')->on('pre_registers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pj_barantins');
    }
};
