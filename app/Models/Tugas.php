<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    public $timestamps = false;

    protected $fillable = [
        'id_kelas',
        'id_mapel',
        'id_tahun_ajaran',
        'semester',
        'kategori',
        'tanggal',
        'nilai',
        'kkm',
        'keterangan',
        'id_user',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'integer',
        'kkm' => 'integer',
    ];

    /**
     * Relasi ke model Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Relasi ke model Mapel
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    /**
     * Relasi ke model TahunAjaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    /**
     * Relasi ke model User (guru/pengguna yang membuat tugas)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
