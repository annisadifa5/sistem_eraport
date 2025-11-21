<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';
    public $timestamps = false;
    protected $fillable = [
        'nama_mapel',
        'nama_singkat',
        'id_guru',
    ];


    /**
     * Relasi ke tabel guru (One to Many atau One to One tergantung kebutuhan)
     * id_guru pada tabel mapel adalah foreign key ke tabel guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }
}
