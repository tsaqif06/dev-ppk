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
        Schema::table('dokumen_pendukungs', function (Blueprint $table) {
            $table->uuid('pengajuan_update_pj_id')->after('pre_register_id')->nullable();
            $table->foreign('pengajuan_update_pj_id')->references('id')->on('pengajuan_update_pjs')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_pendukungs', function (Blueprint $table) {
            $table->dropForeign('dokumen_pendukungs_pengajuan_update_pj_id_foreign');
            $table->dropColumn('pengajuan_update_pj_id');

        });
    }
};
