<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const CHUNK_SIZE = 200;
    const TOTAL_RECORDS = 200;
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < self::TOTAL_RECORDS; $i += self::CHUNK_SIZE) {
            $projects = [];

            for ($j = 0; $j < self::CHUNK_SIZE; $j++) {
                $projects[] = [
                    'kode_transaksi' => str_pad($i + $j + 1, 6, '0', STR_PAD_LEFT),
                    'nama_transaksi' => $faker->company() . ' Material Project',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Transaksi::insert($projects);
        }
    }
}
