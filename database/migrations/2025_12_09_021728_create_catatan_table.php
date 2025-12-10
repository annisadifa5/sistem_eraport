<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_rapor', function (Blueprint $table) {
            $table->id('id_catatan');

            // Relasi
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_siswa');

            // Field catatan
            $table->text('kokurikuler')->nullable();
            $table->json('ekskul')->nullable(); // pakai JSON karena bisa banyak data

            // Ketidakhadiran
            $table->integer('sakit')->nullable()->default(0);
            $table->integer('izin')->nullable()->default(0);
            $table->integer('tanpa_keterangan')->nullable()->default(0);

            $table->timestamps();

            // Foreign key (optional, kalau tabelnya sudah ada)
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_rapor');
    }
};
