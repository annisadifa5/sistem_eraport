<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_sekolah', function (Blueprint $table) {

            // Primary Key
            $table->integer('id_infosekolah')->autoIncrement()->change();

            // Kolom-kolom lainnya
            $table->string('nama_sekolah', 150)->change();
            $table->string('jenjang', 50)->change();
            $table->string('nisn', 50)->change();
            $table->string('npsn', 50)->change();
            $table->string('jalan', 200)->change();
            $table->string('kelurahan', 100)->change();
            $table->string('kecamatan', 100)->change();
            $table->string('kota_kab', 100)->change();
            $table->string('provinsi', 100)->change();
            $table->string('kode_pos', 10)->change();
            $table->string('email', 100)->change();
            $table->string('website', 100)->change();
            $table->string('nama_kepsek', 100)->change();
            $table->string('nip_kepsek', 50)->change();
            $table->string('telp_fax', 50)->change();
        });
    }

    public function down(): void
    {
        // Bisa dikosongkan jika tidak butuh rollback
    }
};
