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
        Schema::table('detail_siswa', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('kelurahan')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('kode_pos')->nullable()->change();
            $table->string('no_hp')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('rt')->nullable()->change();
            $table->string('rw')->nullable()->change();
            $table->string('dusun')->nullable()->change();
            $table->string('jenis_tinggal')->nullable()->change();
            $table->string('alat_transportasi')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->string('skhun')->nullable()->change();
            $table->string('penerima_kps')->nullable()->change();
            $table->string('no_kps')->nullable()->change();
            $table->string('rombel')->nullable()->change();
            $table->string('no_peserta_ujian_nasional')->nullable()->change();
            $table->string('no_seri_ijazah')->nullable()->change();
            $table->string('penerima_kip')->nullable()->change();
            $table->string('no_kip')->nullable()->change();
            $table->string('nama_kip')->nullable()->change();
            $table->string('no_kks')->nullable()->change();
            $table->string('no_regis_akta_lahir')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('no_rek_bank')->nullable()->change();
            $table->string('rek_atas_nama')->nullable()->change();
            $table->string('layak_pip_usulan')->nullable()->change();
            $table->string('alasan_layak_pip')->nullable()->change();
            $table->string('kebutuhan_khusus')->nullable()->change();
            $table->string('sekolah_asal')->nullable()->change();
            $table->string('anak_ke_berapa')->nullable()->change();
            $table->string('lintang')->nullable()->change();
            $table->string('bujur')->nullable()->change();
            $table->string('no_kk')->nullable()->change();
            $table->string('bb')->nullable()->change();
            $table->string('tb')->nullable()->change();
            $table->string('lingkar_kepala')->nullable()->change();
            $table->string('jml_saudara_kandung')->nullable()->change();
            $table->string('jarak_rumah')->nullable()->change();

            // AYAH
            $table->string('nama_ayah')->nullable()->change();
            $table->string('pekerjaan_ayah')->nullable()->change();
            $table->string('tahun_lahir_ayah')->nullable()->change();
            $table->string('jenjang_pendidikan_ayah')->nullable()->change();
            $table->string('penghasilan_ayah')->nullable()->change();
            $table->string('nik_ayah')->nullable()->change();

            // IBU
            $table->string('nama_ibu')->nullable()->change();
            $table->string('pekerjaan_ibu')->nullable()->change();
            $table->string('tahun_lahir_ibu')->nullable()->change();
            $table->string('jenjang_pendidikan_ibu')->nullable()->change();
            $table->string('penghasilan_ibu')->nullable()->change();
            $table->string('nik_ibu')->nullable()->change();

            // WALI
            $table->string('nama_wali')->nullable()->change();
            $table->string('pekerjaan_wali')->nullable()->change();
            $table->string('tahun_lahir_wali')->nullable()->change();
            $table->string('jenjang_pendidikan_wali')->nullable()->change();
            $table->string('penghasilan_wali')->nullable()->change();
            $table->string('nik_wali')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
