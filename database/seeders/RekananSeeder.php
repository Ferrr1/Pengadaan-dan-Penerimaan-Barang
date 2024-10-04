<?php

namespace Database\Seeders;

use App\Models\Rekanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const CHUNK_SIZE = 200;
    const TOTAL_RECORDS = 200;

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < self::TOTAL_RECORDS; $i += self::CHUNK_SIZE) {
            $rekanans = [];

            for ($j = 0; $j < self::CHUNK_SIZE; $j++) {
                $rekanans[] = [
                    'kode_rekanan' => str_pad($i + $j + 1, 6, '0', STR_PAD_LEFT),
                    'nama_rekanan' => $faker->company(),
                    'alamat_rekanan' => $faker->address(),
                    'telepon_rekanan' => $faker->phoneNumber(),
                    'email_rekanan' => $faker->unique()->companyEmail(),
                    'status_rekanan' => $faker->randomElement(['aktif', 'tidak_aktif']),
                    'tgl_bergabung' => $faker->date(),
                    'tgl_akhir' => $faker->date(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Rekanan::insert($rekanans);

            // Optional: Clear the Faker unique() cache every chunk to prevent running out of unique values
            $faker->unique(true);
        }
    }
}
