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
        if (!Schema::hasTable('kelas')) {
        Schema::create('kelas', function (Blueprint $table) {
            $table->integer('id_kelas');
            $table->string('nama_kelas', 100);
            $table->string('tingkat', 50);
            $table->string('jurusan', 100)->nullable();
            $table->string('wali_kelas', 100)->nullable();
            $table->integer('jumlah_siswa')->default(0);
             $table->integer('id_guru')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('id_guru')->nullable(false)->change();
        });
    }
};
