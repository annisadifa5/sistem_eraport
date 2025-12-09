<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catatan', function (Blueprint $table) {
            $table->integer('id_catatan')->autoIncrement();
            // Relasi (integer)
            $table->integer('id_siswa');
            $table->integer('id_kelas');
            $table->integer('id_ekskul')->nullable();

            // Isi catatan
            $table->text('konkurikuler')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('sakit')->default(0);
            $table->integer('ijin')->default(0);
            $table->integer('alpha')->default(0);
            $table->text('catatan_wali_kelas')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_siswa')
                ->references('id_siswa')
                ->on('siswa')
                ->onDelete('cascade');

            $table->foreign('id_kelas')
                ->references('id_kelas')
                ->on('kelas')
                ->onDelete('cascade');

            $table->foreign('id_ekskul')
                ->references('id_ekskul')
                ->on('ekskul')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan');
    }
};
