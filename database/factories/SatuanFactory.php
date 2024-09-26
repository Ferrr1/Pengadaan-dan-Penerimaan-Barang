<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Satuan>
 */
class SatuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_satuan' => fake()->randomNumber(6, true),
            'nama_satuan' => fake()->text(12),
            'singkatan_satuan' => fake()->word(),
            'deskripsi_satuan' => fake()->paragraph(1),
        ];
    }
}
