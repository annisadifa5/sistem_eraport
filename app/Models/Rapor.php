<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    protected $table = 'rapor';
    protected $primaryKey = 'id_rapor';
    public $incrementing = true; // kalau id_rapor auto increment
    protected $keyType = 'int';

    protected $fillable = [
        'id_rapor', 
        'id_kelas', 
        'id_mapel', 
        'id_siswa', 
        'nilai', 
        'capaian'
    ];

    public function rapor()
    {
        return $this->belongsTo(Rapor::class, 'id_rapor');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}