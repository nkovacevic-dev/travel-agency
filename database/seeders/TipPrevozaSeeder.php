<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipPrevozaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $tipovi = [
            ['naziv' => 'Autobus'],
            ['naziv' => 'Avion'],
        ];

        DB::table('tip_prevozas')->insert($tipovi);
    }
}
