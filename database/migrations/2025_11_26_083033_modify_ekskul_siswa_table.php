<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ekskul_siswa', function (Blueprint $table) {

            // Tambahkan foreign key
            // Uji dulu: jika FK sudah ada, Laravel tidak akan error
            try {
                $table->foreign('id_siswa')
                    ->references('id_siswa')
                    ->on('siswa')
                    ->onDelete('cascade');
            } catch (\Exception $e) {}

            try {
                $table->foreign('id_ekskul')
                    ->references('id_ekskul')
                    ->on('ekskul')
                    ->onDelete('cascade');
            } catch (\Exception $e) {}
        });
    }

    public function down()
    {
        Schema::table('ekskul_siswa', function (Blueprint $table) {
            $table->dropForeign(['id_siswa']);
            $table->dropForeign(['id_ekskul']);
        });
    }
};
