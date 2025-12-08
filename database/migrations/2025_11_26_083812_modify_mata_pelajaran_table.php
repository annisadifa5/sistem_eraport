<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_pelajaran', function (Blueprint $table) {

            // Primary Key
            $table->integer('id_mapel')->autoIncrement()->change();

            // Kolom wajib
            $table->string('nama_mapel', 100)->change();
            $table->string('nama_singkat', 100)->change();

            // Foreign Key opsional (boleh NULL)
            $table->integer('id_guru')->nullable()->change();
            $table->integer('id_pembelajaran')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kosongkan jika rollback tidak diperlukan
    }
};
