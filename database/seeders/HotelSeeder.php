<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hotels')->insert([
            [
                'naziv' => 'Hotel Splendid',
                'broj_zvezdica' => 5,
                'adresa' => 'Obala 123',
                'grad' => 'Budva',
                'id_drzave' => 33,
                'telefon' => '+382 33 123 456',
                'email' => 'info@splendid.me',
                'opis' => 'Luksuzni hotel sa SPA centrom i bazenom.',
            ],
            [
                'naziv' => 'Hotel Avala',
                'broj_zvezdica' => 4,
                'adresa' => 'Rivijera 45',
                'grad' => 'Budva',
                'id_drzave' => 33,
                'telefon' => '+382 33 654 321',
                'email' => 'info@avala.me',
                'opis' => 'Moderan hotel sa prelepim pogledom na more.',
            ],
            [
                'naziv' => 'Hotel Le Meurice',
                'broj_zvezdica' => 5,
                'adresa' => '228 Rue de Rivoli',
                'grad' => 'Pariz',
                'id_drzave' => 16,
                'telefon' => '+33 1 44 58 10 10',
                'email' => 'info@lemeurice.com',
                'opis' => 'Ikonski luksuzni hotel u centru Pariza.',
            ],
            [
                'naziv' => 'Hotel Ritz Paris',
                'broj_zvezdica' => 5,
                'adresa' => '15 Place Vendôme',
                'grad' => 'Pariz',
                'id_drzave' => 16,
                'telefon' => '+33 1 43 16 30 30',
                'email' => 'info@ritzparis.com',
                'opis' => 'Elegantan hotel sa bogatom istorijom.',
            ],

            [
                'naziv' => 'Grand Hotel Kopaonik',
                'broj_zvezdica' => 4,
                'adresa' => 'Ski Resort 10',
                'grad' => 'Kopaonik',
                'id_drzave' => 42,
                'telefon' => '+381 37 123 456',
                'email' => 'info@grandkop.com',
                'opis' => 'Hotel sa ski-in/ski-out pristupom i wellness centrom.',
            ],
            [
                'naziv' => 'Hotel Angella',
                'broj_zvezdica' => 4,
                'adresa' => 'Put Skijališta 12',
                'grad' => 'Kopaonik',
                'id_drzave' => 42,
                'telefon' => '+381 37 654 321',
                'email' => 'info@angella.com',
                'opis' => 'Komforan hotel sa panoramskim pogledom na planinu.',
            ],

            [
                'naziv' => 'Hotel Athena',
                'broj_zvezdica' => 4,
                'adresa' => 'Odos 45',
                'grad' => 'Atina',
                'id_drzave' => 19,
                'telefon' => '+30 21 1234 5678',
                'email' => 'info@athena.gr',
                'opis' => 'Moderan hotel u centru Atine.',
            ],
            [
                'naziv' => 'Hotel Electra Palace',
                'broj_zvezdica' => 5,
                'adresa' => 'Nikis 18-20',
                'grad' => 'Atina',
                'id_drzave' => 19,
                'telefon' => '+30 21 0987 6543',
                'email' => 'info@electra.gr',
                'opis' => 'Luksuzni hotel sa pogledom na Akropolj.',
            ],

            [
                'naziv' => 'MS Adriatic Cruise',
                'broj_zvezdica' => 5,
                'adresa' => 'Port Dubrovnik',
                'grad' => 'Dubrovnik',
                'id_drzave' => 10,
                'telefon' => '+385 20 123 456',
                'email' => 'info@adriaticcruise.hr',
                'opis' => 'Luksuzni brod sa kabinama i restoranima.',
            ],
            [
                'naziv' => 'Hotel Excelsior',
                'broj_zvezdica' => 5,
                'adresa' => 'Frana Supila 12',
                'grad' => 'Dubrovnik',
                'id_drzave' => 10,
                'telefon' => '+385 20 654 321',
                'email' => 'info@excelsior.com',
                'opis' => 'Ekskluzivni hotel pored mora sa spa centrom.',
            ],

            [
                'naziv' => 'Alpine Resort',
                'broj_zvezdica' => 4,
                'adresa' => 'Bergstraße 5',
                'grad' => 'Innsbruck',
                'id_drzave' => 4,
                'telefon' => '+43 512 123456',
                'email' => 'info@alpine.at',
                'opis' => 'Ski hotel sa wellness centrom i pogledom na Alpe.',
            ],
            [
                'naziv' => 'Hotel Tirolerhof',
                'broj_zvezdica' => 4,
                'adresa' => 'Maria-Theresien-Str. 18',
                'grad' => 'Innsbruck',
                'id_drzave' => 4,
                'telefon' => '+43 512 654321',
                'email' => 'info@tirolerhof.at',
                'opis' => 'Komforan hotel blizu ski staza i centra grada.',
            ],
        ]);
    }
}
