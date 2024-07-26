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
        Schema::table('registers', function (Blueprint $table) {
            $table->uuid('pre_register_id')->nullable()->after('id');
            $table->foreign('pre_register_id')->references('id')->on('pre_registers')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registers', function (Blueprint $table) {
            $table->dropForeign('registers_pre_register_id_foreign');
            $table->dropColumn('pre_register_id');
        });
    }
};
