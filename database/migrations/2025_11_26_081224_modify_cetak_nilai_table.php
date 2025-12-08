<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cetak_nilai', function (Blueprint $table) {

            // Pastikan unsigned supaya bisa FK
            $table->integer('id_siswa')->change();
            $table->integer('id_kelas')->change();
            $table->integer('id_wali')->change();
            $table->integer('id_tahun_ajaran')->change();
            $table->integer('id_user')->change();
            $table->integer('id_tugas')->change();
            $table->integer('id_uh')->change();
            $table->integer('id_sts')->change();
            $table->integer('id_sas')->change();
            $table->integer('id_sat')->change();
            $table->integer('id_ekskul')->change();
        });
    }

    public function down(): void
    {
        Schema::table('cetak_nilai', function (Blueprint $table) {
            $table->dropForeign(['id_siswa']);
            $table->dropForeign(['id_kelas']);
            $table->dropForeign(['id_wali']);
            $table->dropForeign(['id_tahun_ajaran']);
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_tugas']);
            $table->dropForeign(['id_uh']);
            $table->dropForeign(['id_sts']);
            $table->dropForeign(['id_sas']);
            $table->dropForeign(['id_sat']);
            $table->dropForeign(['id_ekskul']);
        });
    }
};
