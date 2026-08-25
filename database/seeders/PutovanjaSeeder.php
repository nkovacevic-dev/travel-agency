<?php

namespace Database\Seeders;

use App\Models\Putovanje;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PutovanjaSeeder extends Seeder
{
    public function run(): void
    {
        $putovanja = [
            [
                'putovanje' => [
                    'naziv' => 'Jadransko letovanje',
                    'id_drzave' => '33',
                    'grad' => 'Budva',
                    'mesto_polaska' => 'Beograd',
                    'broj_dana' => 10,
                    'broj_nocenja' => 9,
                    'cena' => 350.00,
                    'id_hotela' => '1',
                    'id_tip_prevoza' => 1,
                    'prevoznik' => 'Autoprevoz Beograd',
                    'program_putovanja' => 'Dan 1: Polazak, Dan 2-9: Plaža i izleti, Dan 10: Povratak',
                    'fakultativni_izleti' => 'Ostrvo Sveti Stefan, Nacionalni park Lovćen',
                ],
                'termini' => [
                    ['datum_od' => '2026-09-01', 'datum_do' => '2026-09-10', 'broj_dostupnih_mesta' => 30],
                    ['datum_od' => '2026-09-15', 'datum_do' => '2026-09-24', 'broj_dostupnih_mesta' => 25],
                ],
            ],
            [
                'putovanje' => [
                    'naziv' => 'Avionsko putovanje u Pariz',
                    'id_drzave' => '16',
                    'grad' => 'Pariz',
                    'mesto_polaska' => 'Beograd',
                    'broj_dana' => 8,
                    'broj_nocenja' => 7,
                    'cena' => 850.00,
                    'id_hotela' => '3',
                    'id_tip_prevoza' => 2,
                    'prevoznik' => 'Air Serbia',
                    'program_putovanja' => 'Dan 1: Dolazak, Dan 2-7: Razgledanje, Dan 8: Povratak',
                    'fakultativni_izleti' => 'Luvr, Ajfelov toranj, Versaj',
                ],
                'termini' => [
                    ['datum_od' => '2026-09-28', 'datum_do' => '2026-10-05', 'broj_dostupnih_mesta' => 20],
                    ['datum_od' => '2026-10-12', 'datum_do' => '2026-10-19', 'broj_dostupnih_mesta' => 20],
                ],
            ],
            [
                'putovanje' => [
                    'naziv' => 'Planinski odmor',
                    'id_drzave' => '42',
                    'grad' => 'Kopaonik',
                    'mesto_polaska' => 'Niš',
                    'broj_dana' => 8,
                    'broj_nocenja' => 7,
                    'cena' => 450.00,
                    'id_hotela' => '5',
                    'id_tip_prevoza' => 1,
                    'prevoznik' => 'Planinski prevoz',
                    'program_putovanja' => 'Dan 1: Dolazak, Dan 2-7: Skijanje i wellness, Dan 8: Povratak',
                    'fakultativni_izleti' => 'Ski škola, Noćno sankanje',
                ],
                'termini' => [
                    ['datum_od' => '2026-12-20', 'datum_do' => '2026-12-27', 'broj_dostupnih_mesta' => 15],
                    ['datum_od' => '2027-01-10', 'datum_do' => '2027-01-17', 'broj_dostupnih_mesta' => 15],
                ],
            ],
            [
                'putovanje' => [
                    'naziv' => 'Egzotična tura u Grčku',
                    'id_drzave' => '19',
                    'grad' => 'Atina',
                    'mesto_polaska' => 'Beograd',
                    'broj_dana' => 8,
                    'broj_nocenja' => 7,
                    'cena' => 950.00,
                    'id_hotela' => '7',
                    'id_tip_prevoza' => 2,
                    'prevoznik' => 'Aegean Airlines',
                    'program_putovanja' => 'Dan 1: Dolazak, Dan 2-6: Razgledanje, Dan 7-8: Povratak',
                    'fakultativni_izleti' => 'Akropolj, Plaka, Santorini izlet',
                ],
                'termini' => [
                    ['datum_od' => '2026-10-05', 'datum_do' => '2026-10-12', 'broj_dostupnih_mesta' => 25],
                    ['datum_od' => '2026-10-19', 'datum_do' => '2026-10-26', 'broj_dostupnih_mesta' => 25],
                ],
            ],
            [
                'putovanje' => [
                    'naziv' => 'Jadransko krstarenje',
                    'id_drzave' => '10',
                    'grad' => 'Dubrovnik',
                    'mesto_polaska' => 'Split',
                    'broj_dana' => 8,
                    'broj_nocenja' => 7,
                    'cena' => 700.00,
                    'id_hotela' => '9',
                    'id_tip_prevoza' => 1,
                    'prevoznik' => 'Jadranski prevoznik',
                    'program_putovanja' => 'Dan 1: Polazak i ukrcaj, Dan 2-6: Obilasci luka, Dan 7-8: Povratak',
                    'fakultativni_izleti' => 'Mljet, Korčula, Hvar',
                ],
                'termini' => [
                    ['datum_od' => '2026-09-07', 'datum_do' => '2026-09-14', 'broj_dostupnih_mesta' => 40],
                    ['datum_od' => '2026-09-21', 'datum_do' => '2026-09-28', 'broj_dostupnih_mesta' => 40],
                ],
            ],
            [
                'putovanje' => [
                    'naziv' => 'Zimski ski vikend u Austriji',
                    'id_drzave' => '4',
                    'grad' => 'Innsbruck',
                    'mesto_polaska' => 'Novi Sad',
                    'broj_dana' => 6,
                    'broj_nocenja' => 5,
                    'cena' => 600.00,
                    'id_hotela' => '11',
                    'id_tip_prevoza' => 1,
                    'prevoznik' => 'Europrevoz',
                    'program_putovanja' => 'Dan 1: Polazak, Dan 2-5: Skijanje i wellness, Dan 6: Povratak',
                    'fakultativni_izleti' => 'Nordic ski, Snowboard park',
                ],
                'termini' => [
                    ['datum_od' => '2027-01-24', 'datum_do' => '2027-01-29', 'broj_dostupnih_mesta' => 18],
                    ['datum_od' => '2027-02-07', 'datum_do' => '2027-02-12', 'broj_dostupnih_mesta' => 18],
                ],
            ],
        ];

        foreach ($putovanja as $data) {
            $putovanje = Putovanje::create($data['putovanje']);
            $putovanje->termini()->createMany($data['termini']);
        }
    }
}