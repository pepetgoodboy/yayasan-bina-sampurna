<?php

namespace Database\Seeders;

use App\Models\PertanyaanKeamanan;
use Illuminate\Database\Seeder;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PertanyaanKeamanan::create(['pertanyaan' => 'Apa nama hewan peliharaan pertama Anda?']);
        PertanyaanKeamanan::create(['pertanyaan' => 'Apa nama jalan tempat Anda dibesarkan?']);
        PertanyaanKeamanan::create(['pertanyaan' => 'Siapa nama guru favorit Anda?']);
        PertanyaanKeamanan::create(['pertanyaan' => 'Apa makanan favorit Anda?']);
        PertanyaanKeamanan::create(['pertanyaan' => 'Apa nama kota kelahiran Anda?']);
        PertanyaanKeamanan::create(['pertanyaan' => 'Apa nama tempat pertama Anda tinggal?']);
        PertanyaanKeamanan::create(['pertanyaan' => 'Apa nama sekolah pertama Anda?']);
    }
}
