<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = [];

        for ($i = 1; $i <= 100; $i++) {
            $produks[] = [
                'kode_produk' => str_pad($i, 6, '0', STR_PAD_LEFT),
                'nama_produk' => fake()->randomElement([
                    'Batu Bata',
                    'Semen 50kg',
                    'Pasir Urug',
                    'Besik Ulir 12mm',
                    'Keramik 60x60',
                    'Kayu Balok',
                    'Besi Beton',
                    'Gypsum',
                    'Pintu Kayu',
                    'Kaca',
                    'Aluminium',
                    'Cat Tembok',
                    'Asbes',
                    'Tangki Air',
                    'Paku',
                    'Kabel Listrik',
                    'Lampu Proyek',
                    'Pipa PVC',
                    'Pelapis Anti Bocor',
                    'Keramik Dinding'
                ]),
                'harga_produk' => fake()->numberBetween(50000, 500000),
                'satuan_id' => Satuan::inRandomOrder()->first()->id,
            ];
        }

        Produk::query()->insert($produks);
    }
}
