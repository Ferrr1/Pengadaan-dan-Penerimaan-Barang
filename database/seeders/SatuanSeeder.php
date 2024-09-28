<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Satuan::factory(100)->create();
        $satuans = [
            // Satuan Berat
            ['kode_satuan' => '000001', 'nama_satuan' => 'Kilogram', 'singkatan_satuan' => 'kg', 'deskripsi_satuan' => 'Satuan berat untuk material yang beratnya dihitung dalam kilogram.'],
            ['kode_satuan' => '000002', 'nama_satuan' => 'Gram', 'singkatan_satuan' => 'g', 'deskripsi_satuan' => 'Satuan kecil untuk material dengan berat yang sangat ringan.'],
            ['kode_satuan' => '000003', 'nama_satuan' => 'Ton', 'singkatan_satuan' => 'ton', 'deskripsi_satuan' => 'Satuan berat besar yang biasa digunakan untuk barang-barang berat dalam proyek besar.'],

            // Satuan Panjang
            ['kode_satuan' => '000004', 'nama_satuan' => 'Meter', 'singkatan_satuan' => 'm', 'deskripsi_satuan' => 'Satuan panjang dasar yang sering digunakan untuk mengukur bahan bangunan.'],
            ['kode_satuan' => '000005', 'nama_satuan' => 'Centimeter', 'singkatan_satuan' => 'cm', 'deskripsi_satuan' => 'Satuan panjang untuk bahan yang lebih kecil dari meter.'],
            ['kode_satuan' => '000006', 'nama_satuan' => 'Millimeter', 'singkatan_satuan' => 'mm', 'deskripsi_satuan' => 'Satuan panjang terkecil untuk pengukuran yang sangat presisi.'],
            ['kode_satuan' => '000007', 'nama_satuan' => 'Inch', 'singkatan_satuan' => 'in', 'deskripsi_satuan' => 'Satuan panjang imperial yang terkadang digunakan dalam proyek tertentu.'],
            ['kode_satuan' => '000008', 'nama_satuan' => 'Foot', 'singkatan_satuan' => 'ft', 'deskripsi_satuan' => 'Satuan panjang imperial yang lebih besar, terutama digunakan di negara dengan sistem imperial.'],

            // Satuan Luas
            ['kode_satuan' => '000009', 'nama_satuan' => 'Square Meter', 'singkatan_satuan' => 'm²', 'deskripsi_satuan' => 'Satuan untuk mengukur luas area, seperti lantai, dinding, dan permukaan lainnya.'],
            ['kode_satuan' => '000010', 'nama_satuan' => 'Hectare', 'singkatan_satuan' => 'ha', 'deskripsi_satuan' => 'Satuan besar untuk mengukur luas tanah atau area yang luas.'],
            ['kode_satuan' => '000011', 'nama_satuan' => 'Acre', 'singkatan_satuan' => 'ac', 'deskripsi_satuan' => 'Satuan luas yang lebih umum digunakan di negara-negara yang menggunakan sistem imperial.'],

            // Satuan Volume
            ['kode_satuan' => '000012', 'nama_satuan' => 'Cubic Meter', 'singkatan_satuan' => 'm³', 'deskripsi_satuan' => 'Satuan volume yang digunakan untuk bahan seperti beton atau pasir.'],
            ['kode_satuan' => '000013', 'nama_satuan' => 'Liter', 'singkatan_satuan' => 'L', 'deskripsi_satuan' => 'Satuan volume yang digunakan untuk cairan seperti air, cat, dll.'],
            ['kode_satuan' => '000014', 'nama_satuan' => 'Cubic Centimeter', 'singkatan_satuan' => 'cm³', 'deskripsi_satuan' => 'Satuan volume yang lebih kecil untuk benda berukuran kecil atau cairan dalam jumlah kecil.'],
            ['kode_satuan' => '000015', 'nama_satuan' => 'Barrel', 'singkatan_satuan' => 'bbl', 'deskripsi_satuan' => 'Satuan volume yang biasanya digunakan untuk minyak atau cairan dalam jumlah besar.'],
            ['kode_satuan' => '000016', 'nama_satuan' => 'Gallon', 'singkatan_satuan' => 'gal', 'deskripsi_satuan' => 'Satuan volume imperial yang sering digunakan di AS.'],

            // Satuan Jumlah
            ['kode_satuan' => '000017', 'nama_satuan' => 'Unit', 'singkatan_satuan' => 'unit', 'deskripsi_satuan' => 'Satuan umum untuk barang yang dihitung per item.'],
            ['kode_satuan' => '000018', 'nama_satuan' => 'Pack', 'singkatan_satuan' => 'pack', 'deskripsi_satuan' => 'Satuan untuk paket atau set barang.'],
            ['kode_satuan' => '000019', 'nama_satuan' => 'Box', 'singkatan_satuan' => 'box', 'deskripsi_satuan' => 'Satuan untuk barang-barang yang dikemas dalam kotak.'],
            ['kode_satuan' => '000020', 'nama_satuan' => 'Dozen', 'singkatan_satuan' => 'dozen', 'deskripsi_satuan' => 'Satuan untuk barang-barang yang dihitung per lusin.'],

            // Satuan Waktu
            ['kode_satuan' => '000021', 'nama_satuan' => 'Hour', 'singkatan_satuan' => 'hr', 'deskripsi_satuan' => 'Satuan waktu yang digunakan dalam estimasi waktu kerja atau operasional.'],
            ['kode_satuan' => '000022', 'nama_satuan' => 'Day', 'singkatan_satuan' => 'day', 'deskripsi_satuan' => 'Satuan waktu yang sering digunakan dalam kontrak kerja atau durasi proyek.'],

            // Satuan Energi
            ['kode_satuan' => '000023', 'nama_satuan' => 'Kilowatt-hour', 'singkatan_satuan' => 'kWh', 'deskripsi_satuan' => 'Satuan energi yang biasa digunakan untuk mengukur penggunaan listrik.'],

            // Satuan Tekanan
            ['kode_satuan' => '000024', 'nama_satuan' => 'Pascal', 'singkatan_satuan' => 'Pa', 'deskripsi_satuan' => 'Satuan tekanan yang digunakan untuk pengukuran dalam sistem teknik.'],
            ['kode_satuan' => '000025', 'nama_satuan' => 'Bar', 'singkatan_satuan' => 'bar', 'deskripsi_satuan' => 'Satuan tekanan yang sering digunakan untuk mengukur tekanan udara atau gas.'],
        ];

        Satuan::query()->insert($satuans);
    }
}
