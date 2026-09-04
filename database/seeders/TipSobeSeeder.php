<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipSobeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $tipovi = [
            ['naziv' => 'Jednokrevetna'],
            ['naziv' => 'Dvokrevetna'],
            ['naziv' => 'Trokrevetna'],
            ['naziv' => 'Četvorokrevetna'],
        ];

        DB::table('tip_sobe')->insert($tipovi);
    }
}
