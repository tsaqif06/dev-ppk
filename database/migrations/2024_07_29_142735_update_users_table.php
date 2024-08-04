<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('email')->nullable(); // Menambahkan kolom 'name' setelah kolom 'email'
            } else {
                // Jika kolom sudah ada dan Anda perlu mengubahnya
                $table->string('name')->nullable(false)->change(); // Ubah kolom 'name' menjadi tidak nullable
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika Anda ingin membatalkan perubahan ini, Anda bisa melakukannya di sini
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name'); // Menghapus kolom 'name' jika diperlukan
            }
        });
    }
}
