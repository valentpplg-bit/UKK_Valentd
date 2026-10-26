<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'id_user',
        'nis',
        'nama_lengkap',
        'alamat',
        'kelas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}