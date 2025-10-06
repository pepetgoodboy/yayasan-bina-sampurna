<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    
    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'id_kelas',
        'id_ortu',
        'gelombang'
    ];
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    
    public function ortu()
    {
        return $this->belongsTo(User::class, 'id_ortu');
    }
    
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_siswa');
    }
}
