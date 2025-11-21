<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STS extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'sts';

    // Primary Key
    protected $primaryKey = 'id_sts';

    // Primary key auto increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Tidak menggunakan created_at dan updated_at
    public $timestamps = false;

    // Kolom yang bisa diisi (mass assignment)
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
        'id_user'
    ];

    /**
     * ========== RELATIONSHIP ==========
     * Sesuaikan dengan model yang sudah ada pada project kamu
     */

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
