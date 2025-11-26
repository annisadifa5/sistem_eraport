<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_tugas', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('mapel_id');

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
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_tugas');
    }
};
