<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Tambah kelas jika belum ada
        $kelasData = ['1A', '1B', '1C', '2A', '2B', '2C', '3A', '3B', '3C'];
        
        foreach ($kelasData as $namaKelas) {
            Kelas::firstOrCreate(['nama_kelas' => $namaKelas]);
        }
        
        $kelasList = Kelas::all();
        $totalKelas = $kelasList->count();
        
        // Generate 150 siswa dengan orang tua
        $startNumber = Siswa::max('id') + 1 ?? 1;
        
        for ($i = 0; $i < 150; $i++) {
            $number = $startNumber + $i;
            
            // Skip jika email sudah ada
            if (User::where('email', 'ortu' . $number . '@test.com')->exists()) {
                continue;
            }
            
            // Buat user orang tua
            $ortu = User::create([
                'name' => 'Orang Tua ' . $number,
                'email' => 'ortu' . $number . '@test.com',
                'password' => Hash::make('password')
            ]);
            $ortu->assignRole('ortu');
            
            // Pilih kelas secara merata
            $kelasIndex = $i % $totalKelas;
            $kelas = $kelasList[$kelasIndex];
            
            // Generate NIS unik
            $nis = '2025' . str_pad($number, 3, '0', STR_PAD_LEFT);
            
            // Skip jika NIS sudah ada
            if (Siswa::where('nis', $nis)->exists()) {
                $nis = '2025' . str_pad($number + 1000, 3, '0', STR_PAD_LEFT);
            }
            
            // Buat siswa
            Siswa::create([
                'nis' => $nis,
                'nama' => 'Siswa Test ' . $number,
                'id_kelas' => $kelas->id,
                'id_ortu' => $ortu->id
            ]);
        }
    }
}
