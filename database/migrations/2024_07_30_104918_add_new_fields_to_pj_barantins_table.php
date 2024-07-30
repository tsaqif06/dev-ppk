<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPjBarantinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pj_barantins', function (Blueprint $table) {
            $table->integer('rerata_frekuensi')->nullable();
            $table->text('daftar_komoditas')->nullable();
            $table->boolean('tempat_karantina')->default(false);
            $table->string('status_kepemilikan')->nullable();
            $table->string('nomor_registrasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pj_barantin', function (Blueprint $table) {
            $table->dropColumn('rerata_frekuensi');
            $table->dropColumn('daftar_komoditas');
            $table->dropColumn('tempat_karantina');
            $table->dropColumn('status_kepemilikan');
            $table->dropColumn('nomor_registrasi');
        });
    }
}
