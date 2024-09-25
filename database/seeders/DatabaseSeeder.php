<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Maulana Feri Setyawan',
            'email' => 'maulanasetyawan8@gmail.com',
            'password' => Hash::make('1212121212'),
        ]);

        $this->call([
            SatuanSeeder::class,
            // RekananSeeder::class,
            ProjectSeeder::class,
            // AnggaranSeeder::class
        ]);
    }
}
