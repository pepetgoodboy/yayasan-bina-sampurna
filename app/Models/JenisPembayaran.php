<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayaran';
    
    protected $fillable = [
        'nama',
        'jenjang',
        'gender',
        'kelas_min',
        'kelas_max',
        'gelombang',
        'tipe',
        'total_tagihan',
        'bisa_cicil'
    ];
    
    protected $casts = [
        'bisa_cicil' => 'boolean',
        'total_tagihan' => 'decimal:2'
    ];
    
    public function isApplicableForSiswa($siswa)
    {
        // Check jenjang
        if ($this->jenjang && $siswa->kelas) {
            $kelasNama = $siswa->kelas->nama_kelas;
            $jenjangSiswa = str_contains($kelasNama, 'TK') ? 'TK' : 'SD';
            if ($this->jenjang !== $jenjangSiswa) {
                return false;
            }
        }
        
        // Check gender
        if ($this->gender && $this->gender !== 'ALL' && $siswa->jenis_kelamin !== $this->gender) {
            return false;
        }
        
        // Check kelas range for SD
        if ($this->kelas_min && $this->kelas_max && $siswa->kelas) {
            $kelasNama = $siswa->kelas->nama_kelas;
            if (preg_match('/\d+/', $kelasNama, $matches)) {
                $kelasNumber = (int)$matches[0];
                if ($kelasNumber < $this->kelas_min || $kelasNumber > $this->kelas_max) {
                    return false;
                }
            }
        }
        
        // Check gelombang for UDP SD
        if ($this->gelombang && $siswa->gelombang !== $this->gelombang) {
            return false;
        }
        
        return true;
    }
    
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_jenis');
    }
}
