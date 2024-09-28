<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Project::factory(100)->create();
        $projects = [];

        for ($i = 1; $i <= 100; $i++) {
            $projects[] = [
                'kode_project' => str_pad($i, 6, '0', STR_PAD_LEFT),
                'nama_project' => fake()->company() . ' Construction Project',
                'tgl_mulai' => fake()->date(),
                'status_project' => fake()->randomElement(['aktif', 'tidak_aktif']),
            ];
        }
        Project::query()->insert($projects);
    }
}
