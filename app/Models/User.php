<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // nama tabel di database

    protected $primaryKey = 'id_user'; // primary key custom

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'role',        // admin / guru
        'is_walikelas', // 1 = wali kelas  | 0 = bukan
        'status',      // aktif / nonaktif
    ];

    protected $hidden = [
        'password',
    ];

    // Agar Laravel login pakai kolom username
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}
