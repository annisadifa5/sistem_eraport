<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_guru', function (Blueprint $table) {

            // Ubah semua kolom menjadi nullable (TIDAK menambah kolom)
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('status_kepegawaian')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('rt')->nullable()->change();
            $table->string('rw')->nullable()->change();
            $table->string('dusun')->nullable()->change();
            $table->string('kelurahan')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('kode_pos')->nullable()->change();
            $table->string('no_telp')->nullable()->change();
            $table->string('no_hp')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('tugas_tambahan')->nullable()->change();
            $table->string('sk_cpns')->nullable()->change();
            $table->date('tgl_cpns')->nullable()->change();
            $table->string('sk_pengangkatan')->nullable()->change();
            $table->date('tmt_pengangkatan')->nullable()->change();
            $table->string('lembaga_pengangkatan')->nullable()->change();
            $table->string('pangkat_gol')->nullable()->change();
            $table->string('sumber_gaji')->nullable()->change();
            $table->string('nama_ibu_kandung')->nullable()->change();
            $table->string('status_perkawinan')->nullable()->change();
            $table->string('nama_suami_istri')->nullable()->change();
            $table->string('nip_suami_istri')->nullable()->change();
            $table->string('pekerjaan_suami_istri')->nullable()->change();
            $table->date('tmt_pns')->nullable()->change();
            $table->string('lisensi_kepsek')->nullable()->change();
            $table->string('diklat_kepengawasan')->nullable()->change();
            $table->string('keahlian_braille')->nullable()->change();
            $table->string('keahlian_isyarat')->nullable()->change();
            $table->string('npwp')->nullable()->change();
            $table->string('nama_wajib_pajak')->nullable()->change();
            $table->string('kewarganegaraan')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('norek_bank')->nullable()->change();
            $table->string('nama_rek')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('no_kk')->nullable()->change();
            $table->string('karpeg')->nullable()->change();
            $table->string('karis_karsu')->nullable()->change();
            $table->string('lintang')->nullable()->change();
            $table->string('bujur')->nullable()->change();
            $table->string('nuks')->nullable()->change();
        });
    }

    public function down(): void
    {
        //
    }
};
