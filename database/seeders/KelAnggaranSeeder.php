<?php

namespace Database\Seeders;

use App\Models\Kel_Anggaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelAnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelanggarans = [
            [
                'kode_kel_anggaran' => '0001',
                'nama_kel_anggaran' => 'Biaya Material',
            ],
            [
                'kode_kel_anggaran' => '0002',
                'nama_kel_anggaran' => 'Biaya Upah Proyek',
            ],
            [
                'kode_kel_anggaran' => '0003',
                'nama_kel_anggaran' => 'Biaya Upah Administrasi Proyek',
            ],
            [
                'kode_kel_anggaran' => '0004',
                'nama_kel_anggaran' => 'Biaya Sub Kontraktor Proyek',
            ],
            [
                'kode_kel_anggaran' => '0005',
                'nama_kel_anggaran' => 'Biaya Upah Administrasi',
            ],
        ];

        Kel_Anggaran::insert($kelanggarans);
    }
}
