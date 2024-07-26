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
        Schema::table('ppjks', function (Blueprint $table) {
            $table->string('jenis_identitas_ppjk')->after('nama_ppjk')->nullable();
            $table->string('nomor_identitas_ppjk')->after('nama_ppjk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
