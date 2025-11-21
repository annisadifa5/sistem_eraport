<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlanganHarian extends Model
{
    protected $table = 'ulangan_harian';
    protected $primaryKey = 'id_uh';
    public $timestamps = false;

    protected $fillable = [
        'id_siswa',
        'id_mapel',
        'id_kelas',
        'id_tahun_ajaran',
        'semester',
        'tanggal',
        'nilai',
        'kkm',
        'keterangan',
        'id_user',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'decimal:2',
        'kkm' => 'decimal:2',
    ];

    /**
     * Relasi ke model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    /**
     * Relasi ke model Mapel
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    /**
     * Relasi ke model Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Relasi ke model TahunAjaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    /**
     * Relasi ke model User (guru/pembuat nilai)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
