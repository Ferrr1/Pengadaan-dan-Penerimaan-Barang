<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    const CHUNK_SIZE = 200;
    const TOTAL_RECORDS = 200;

    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $satuanIds = Satuan::pluck('id')->toArray();
        $produkNames = [
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
        ];

        for ($i = 0; $i < self::TOTAL_RECORDS; $i += self::CHUNK_SIZE) {
            $produks = [];

            for ($j = 0; $j < self::CHUNK_SIZE; $j++) {
                $produks[] = [
                    'kode_produk' => str_pad($i + $j + 1, 6, '0', STR_PAD_LEFT),
                    'nama_produk' => $faker->randomElement($produkNames),
                    'harga_produk' => $faker->numberBetween(50000, 500000),
                    'satuan_id' => $faker->randomElement($satuanIds),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Produk::insert($produks);
        }
    }
}
