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
        Schema::create('pj_baratan_kpps', function (Blueprint $table) {
            $table->id();

            $table->string('nama_pendaftar')->nullable();
            $table->string('ktp_pendaftar')->nullable();
            $table->unsignedBigInteger('upt_id')->nullable();
            $table->enum('jenis_perusahaan', ['PEMILIK_BARANG', 'PPJK', 'EMKL', 'EMKU', 'LAINNYA']);
            $table->string('kode_perusahaan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->unsignedBigInteger('jenis_identitas')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nomor_identitas')->nullable();
            $table->unsignedInteger('fax')->nullable();
            $table->string('telepon')->nullable();

            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('negara_id')->nullable();
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->unsignedInteger('kota')->nullable();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->unsignedBigInteger('status_import')->nullable();

            $table->string('nama_cp')->nullable();
            $table->string('alamat_cp')->nullable();
            $table->string('telepon_cp')->nullable();

            $table->string('nama_tdd')->nullable();
            $table->unsignedBigInteger('jenis_identitas_tdd')->nullable();
            $table->string('nomor_identitas_tdd')->nullable();
            $table->string('jabatan_tdd')->nullable();
            $table->string('alamat_tdd')->nullable();

            $table->string('kontak_ppjk')->nullable();

            $table->enum('status', ['MENUNGGU', 'DISETUJUI', 'DITOLAK'])->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('is_password');
            $table->text('alasan')->nullable();
            $table->tinyInteger('a1')->default(0);
            $table->tinyInteger('a2')->default(0);
            $table->tinyInteger('a3')->default(0);
            $table->tinyInteger('a4')->default(0);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->unsignedTinyInteger('status_prioritas')->default(0)->comment('1: layanan prioritas; 5: draft ekspor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pj_baratan_kpps');
    }
};
