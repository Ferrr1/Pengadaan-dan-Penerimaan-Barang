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
    public function run(): void
    {
        $rekanans = [];

        for ($i = 1; $i <= 100; $i++) {
            $rekanans[] = [
                'kode_rekanan' => str_pad($i, 6, '0', STR_PAD_LEFT),
                'nama_rekanan' => fake()->company(),
                'alamat_rekanan' => fake()->address(),
                'telepon_rekanan' => fake()->phoneNumber(),
                'email_rekanan' => fake()->unique()->companyEmail(),
                'status_rekanan' => fake()->randomElement(['aktif', 'tidak_aktif']),
                'tgl_bergabung' => fake()->date(),
                'tgl_akhir' => fake()->date(),
            ];
        }

        Rekanan::query()->insert($rekanans);
    }
}
