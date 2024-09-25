<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_project' => fake(),
            'nama_project' => fake()->text(12),
            'tgl_mulai' => fake()->date(),
            'status_project' => fake()->randomElement(['aktif', 'tidak_aktif']),
        ];
    }
}
