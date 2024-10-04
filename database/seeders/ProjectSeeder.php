<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    const CHUNK_SIZE = 200;
    const TOTAL_RECORDS = 200;

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < self::TOTAL_RECORDS; $i += self::CHUNK_SIZE) {
            $projects = [];

            for ($j = 0; $j < self::CHUNK_SIZE; $j++) {
                $projects[] = [
                    'kode_project' => str_pad($i + $j + 1, 6, '0', STR_PAD_LEFT),
                    'nama_project' => $faker->company() . ' Construction Project',
                    'tgl_mulai' => $faker->date(),
                    'status_project' => $faker->randomElement(['aktif', 'tidak_aktif']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Project::insert($projects);
        }
    }
}
