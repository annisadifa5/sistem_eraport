<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru', function (Blueprint $table) {

            // Pastikan kolom sesuai dengan yang ada di database
            $table->integer('id_guru')->autoIncrement()->change();

            $table->string('nama_guru', 255)->nullable()->change();
            $table->string('nip', 255)->nullable()->change();
            $table->string('nuptk', 255)->nullable()->change();
            $table->string('jenis_kelamin', 255)->nullable()->change();
            $table->string('jenis_ptk', 255)->nullable()->change();
            $table->string('role', 255)->nullable()->change();
            $table->string('status', 255)->nullable()->change();

            $table->integer('id_pembelajaran')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Biasanya dibiarkan kosong karena kita hanya menyesuaikan kolom
    }
};
