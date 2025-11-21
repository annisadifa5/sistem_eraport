<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CetakNilai extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'cetak_nilai';

    // Primary key tabel
    protected $primaryKey = 'id_cetak_nilai';

    // Nonaktifkan timestamps karena tidak ada created_at & updated_at
    public $timestamps = false;

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_wali',
        'id_tahun_ajaran',
        'id_user',
        'id_tugas',
        'id_uh',
        'id_sts',
        'id_sas',
        'id_sat',
        'id_ekskul',
        'rata_rata',
        'deskripsi',
        'tanggal',
        'pdf',
    ];

    /**
     * Relasi ke tabel siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Relasi ke tabel kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    /**
     * Relasi ke tabel wali_kelas
     */
    public function wali()
    {
        return $this->belongsTo(WaliKelas::class, 'id_wali', 'id_wali');
    }

    /**
     * Relasi ke tabel tahun_ajaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    /**
     * Relasi ke tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relasi ke tabel tugas
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }

    /**
     * Relasi ke tabel ulangan_harian
     */
    public function ulanganHarian()
    {
        return $this->belongsTo(UlanganHarian::class, 'id_uh', 'id_uh');
    }

    /**
     * Relasi ke tabel sas
     */
    public function sts()
    {
        return $this->belongsTo(Sas::class, 'id_sts', 'id_sas');
    }

    public function sas()
    {
        return $this->belongsTo(Sas::class, 'id_sas', 'id_sas');
    }

    /**
     * Relasi ke tabel sat
     */
    public function sat()
    {
        return $this->belongsTo(Sat::class, 'id_sat', 'id_sat');
    }

     /**
     * Relasi ke tabel ekskul
     */
    public function ekskul()
    {
        return $this->belongsTo(Sat::class, 'id_ekskul', 'id_ekskul');
    }
}
