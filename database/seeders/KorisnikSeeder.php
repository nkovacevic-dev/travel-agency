<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KorisnikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('korisnik')->insert([
            'name' => 'Super Admin',
            'email' => 'natasha949@gmail.com',
            'password' => Hash::make('nkovacevic123'),
        ]);
    }
}
