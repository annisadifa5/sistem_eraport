<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_mapel');

            // Filter tambahan
            $table->string('kategori'); // contoh: Tugas 1, Tugas 2, Ulangan Harian
            $table->date('tanggal');

            // Semester + Tahun ajaran
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran'); // contoh: 2024/2025

            // Nilai
            $table->integer('nilai')->nullable();
            $table->integer('kkm')->default(75);

            $table->timestamps();

            // Foreign key
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas');
    }
};
