<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapor', function (Blueprint $table) {
            $table->integer('id_rapor'); // integer auto increment

            $table->integer('id_kelas');
            $table->integer('id_mapel');
            $table->integer('id_siswa');
            $table->integer('id_tahun_ajaran)');


            $table->tinyInteger('nilai')->nullable();
            $table->text('capaian')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kelas')
                  ->references('id_kelas')
                  ->on('kelas')
                  ->onDelete('cascade');

            $table->foreign('id_mapel')
                  ->references('id_mapel')
                  ->on('mata_pelajaran')
                  ->onDelete('cascade');

            $table->foreign('id_siswa')
                  ->references('id_siswa')
                  ->on('siswa')
                  ->onDelete('cascade');
            
            $table->foreign('id_tahun_ajaran')
                  ->references('id_tahun_ajaran')
                  ->on('tahun_ajaran')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapor');
    }
};
