<?php

namespace Database\Seeders;

use App\Models\Korisnik;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Korisnik::factory(10)->create();

        $this->call([
            KorisnikSeeder::class,
            DrzaveSeeder::class,
            TipPrevozaSeeder::class,
            TipSobeSeeder::class,
            HotelSeeder::class,
            PutovanjaSeeder::class
        ]);
    }
}
