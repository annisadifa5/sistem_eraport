<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event', function (Blueprint $table) {
            // Pastikan kolom sudah sesuai, ubah jika perlu

            $table->integer('id_event')->autoIncrement()->change();
            $table->string('deskripsi', 200)->change();
            $table->date('tanggal')->change();
            $table->string('kategori', 50)->change();
        });
    }

    public function down(): void
    {
        // Biasanya dibiarkan kosong karena kita hanya menyesuaikan struktur yang sudah ada
    }
};
