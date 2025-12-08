<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================
        // 1. TABEL GURU
        // =========================
        Schema::create('guru', function (Blueprint $table) {
            $table->id('id_guru');
            $table->string('nama_guru')->nullable();
            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('jenis_ptk')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // =========================
        // 2. TABEL DETAIL GURU
        // =========================
        Schema::create('detail_guru', function (Blueprint $table) {
            $table->id('id_detail');
            
            $table->unsignedBigInteger('id_guru')->nullable();
            $table->unsignedBigInteger('id_pembelajaran')->nullable();

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status_kepegawaian')->nullable();
            $table->string('agama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('tugas_tambahan')->nullable();
            $table->string('sk_cpns')->nullable();
            $table->date('tgl_cpns')->nullable();
            $table->string('sk_pengangkatan')->nullable();
            $table->date('tmt_pengangkatan')->nullable();
            $table->string('lembaga_pengangkatan')->nullable();
            $table->string('pangkat_gol')->nullable();
            $table->string('sumber_gaji')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('nama_suami_istri')->nullable();
            $table->string('nip_suami_istri')->nullable();
            $table->string('pekerjaan_suami_istri')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->string('lisensi_kepsek')->nullable();
            $table->string('diklat_kepengawasan')->nullable();
            $table->string('keahlian_braille')->nullable();
            $table->string('keahlian_isyarat')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nama_wajib_pajak')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('bank')->nullable();
            $table->string('norek_bank')->nullable();
            $table->string('nama_rek')->nullable();
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('karpeg')->nullable();
            $table->string('karis_karsu')->nullable();
            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();
            $table->string('nuks')->nullable();

            $table->timestamps();

            // tambahkan index dulu
            $table->index('id_guru');

            // FOREIGN KEY
            $table->foreign('id_guru')
                ->references('id_guru')
                ->on('guru')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_guru');
        Schema::dropIfExists('guru');
    }
};
