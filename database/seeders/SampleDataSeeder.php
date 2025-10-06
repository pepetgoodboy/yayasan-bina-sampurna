<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\JenisPembayaran;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample kelas
        $kelasTK = Kelas::create(['nama_kelas' => 'TK A']);
        $kelas1 = Kelas::create(['nama_kelas' => '1A']);
        $kelas2 = Kelas::create(['nama_kelas' => '4B']);
        $kelas3 = Kelas::create(['nama_kelas' => '6A']);
        
        // Create sample orang tua
        $ortu1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'id_pertanyaan' => 1,
            'jawaban' => 'kucing'
        ]);
        $ortu1->assignRole('ortu');
        
        $ortu2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'id_pertanyaan' => 2,
            'jawaban' => 'jalan mawar'
        ]);
        $ortu2->assignRole('ortu');
        
        // Create sample siswa
        Siswa::create([
            'nis' => '2024001',
            'nama' => 'Ahmad Budi',
            'jenis_kelamin' => 'L',
            'id_kelas' => $kelasTK->id,
            'id_ortu' => $ortu1->id
        ]);
        
        Siswa::create([
            'nis' => '2024002',
            'nama' => 'Sari Dewi',
            'jenis_kelamin' => 'P',
            'id_kelas' => $kelas1->id,
            'id_ortu' => $ortu2->id,
            'gelombang' => 1
        ]);
        
        Siswa::create([
            'nis' => '2024003',
            'nama' => 'Andi Pratama',
            'jenis_kelamin' => 'L',
            'id_kelas' => $kelas2->id,
            'id_ortu' => $ortu1->id,
            'gelombang' => 2
        ]);
        
        Siswa::create([
            'nis' => '2024004',
            'nama' => 'Putri Sari',
            'jenis_kelamin' => 'P',
            'id_kelas' => $kelas3->id,
            'id_ortu' => $ortu2->id,
            'gelombang' => 3
        ]);
        
        // Jenis pembayaran akan diisi oleh JenisPembayaranSeeder
    }
}
