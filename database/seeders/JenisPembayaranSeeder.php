<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPembayaran;

class JenisPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data safely
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JenisPembayaran::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // TK Payments
        JenisPembayaran::create([
            'nama' => 'SPP TK',
            'jenjang' => 'TK',
            'gender' => 'ALL',
            'tipe' => 'bulanan',
            'total_tagihan' => 50000,
            'bisa_cicil' => false
        ]);
        
        JenisPembayaran::create([
            'nama' => 'UDP TK',
            'jenjang' => 'TK',
            'gender' => 'ALL',
            'tipe' => 'sekali',
            'total_tagihan' => 250000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'Seragam TK',
            'jenjang' => 'TK',
            'gender' => 'ALL',
            'tipe' => 'sekali',
            'total_tagihan' => 300000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'Peralatan TK',
            'jenjang' => 'TK',
            'gender' => 'ALL',
            'tipe' => 'sekali',
            'total_tagihan' => 250000,
            'bisa_cicil' => true
        ]);
        
        // SD Payments - SPP
        JenisPembayaran::create([
            'nama' => 'SPP SD Kelas 1-3',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'kelas_min' => 1,
            'kelas_max' => 3,
            'tipe' => 'bulanan',
            'total_tagihan' => 150000,
            'bisa_cicil' => false
        ]);
        
        JenisPembayaran::create([
            'nama' => 'SPP SD Kelas 4-6',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'kelas_min' => 4,
            'kelas_max' => 6,
            'tipe' => 'bulanan',
            'total_tagihan' => 125000,
            'bisa_cicil' => false
        ]);
        
        // SD Payments - Seragam
        JenisPembayaran::create([
            'nama' => 'Seragam SD Laki-Laki',
            'jenjang' => 'SD',
            'gender' => 'L',
            'tipe' => 'sekali',
            'total_tagihan' => 300000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'Seragam SD Perempuan',
            'jenjang' => 'SD',
            'gender' => 'P',
            'tipe' => 'sekali',
            'total_tagihan' => 400000,
            'bisa_cicil' => true
        ]);
        
        // SD Payments - Tahunan
        JenisPembayaran::create([
            'nama' => 'Uang Buku SD',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'tipe' => 'tahunan',
            'total_tagihan' => 700000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'Uang Kegiatan SD',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'tipe' => 'tahunan',
            'total_tagihan' => 700000,
            'bisa_cicil' => true
        ]);
        
        // SD Payments - UDP by Gelombang
        JenisPembayaran::create([
            'nama' => 'UDP SD Gelombang 1',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'gelombang' => 1,
            'tipe' => 'sekali',
            'total_tagihan' => 4000000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'UDP SD Gelombang 2',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'gelombang' => 2,
            'tipe' => 'sekali',
            'total_tagihan' => 4250000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'UDP SD Gelombang 3',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'gelombang' => 3,
            'tipe' => 'sekali',
            'total_tagihan' => 4500000,
            'bisa_cicil' => true
        ]);
        
        JenisPembayaran::create([
            'nama' => 'UDP SD Gelombang 4',
            'jenjang' => 'SD',
            'gender' => 'ALL',
            'gelombang' => 4,
            'tipe' => 'sekali',
            'total_tagihan' => 5000000,
            'bisa_cicil' => true
        ]);
    }
}