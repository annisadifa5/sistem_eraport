<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ekskul', function (Blueprint $table) {

            // Pastikan kolom sudah ada - jadi JANGAN ditambah lagi
            // Kita hanya menambahkan foreign key jika dibutuhkan

            if (!Schema::hasColumn('ekskul', 'id_guru')) {
                $table->unsignedBigInteger('id_guru')->nullable();
            }

            if (!Schema::hasColumn('ekskul', 'id_siswa')) {
                $table->unsignedBigInteger('id_siswa')->nullable();
            }

            if (!Schema::hasColumn('ekskul', 'id_ekskul_siswa')) {
                $table->unsignedBigInteger('id_ekskul_siswa')->nullable();
            }

            // FOREIGN KEY (opsional, jika memang ada relasinya)
            // Hati-hati jangan membuat FK jika tabel tujuan belum ada

            // id_guru → guru.id_guru
            // cek dulu kalau foreign key belum ada
            try {
                $table->foreign('id_guru')
                    ->references('id_guru')
                    ->on('guru')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // Abaikan jika sudah ada
            }

            // id_siswa → siswa.id_siswa
            try {
                $table->foreign('id_siswa')
                    ->references('id_siswa')
                    ->on('siswa')
                    ->onDelete('set null');
            } catch (\Exception $e) {}

            // id_ekskul_siswa → ekskul_siswa.id_ekskul_siswa
            try {
                $table->foreign('id_ekskul_siswa')
                    ->references('id_ekskul_siswa')
                    ->on('ekskul_siswa')
                    ->onDelete('set null');
            } catch (\Exception $e) {}

        });
    }

    public function down()
    {
        Schema::table('ekskul', function (Blueprint $table) {
            // Drop FK jika ingin rollback
            $table->dropForeign(['id_guru']);
            $table->dropForeign(['id_siswa']);
            $table->dropForeign(['id_ekskul_siswa']);
        });
    }
};
