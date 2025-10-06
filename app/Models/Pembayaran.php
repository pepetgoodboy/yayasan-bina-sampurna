<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'id_siswa',
        'id_jenis',
        'tanggal_bayar',
        'jumlah_bayar',
        'keterangan'
    ];
    
    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah_bayar' => 'decimal:2'
    ];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
    
    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis');
    }
}
