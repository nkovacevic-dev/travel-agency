<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrzaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $drzave = [
            'Albanija', 'Andora', 'Armenija', 'Austrija', 'Azerbejdžan',
            'Belorusija', 'Belgija', 'Bosna i Hercegovina', 'Bugarska', 'Hrvatska',
            'Kipar', 'Češka', 'Danska', 'Estonija', 'Finska',
            'Francuska', 'Gruzija', 'Nemačka', 'Grčka', 'Mađarska',
            'Island', 'Irska', 'Italija', 'Kazahstan', 'Kosovo',
            'Latvija', 'Lihtenštajn', 'Litvanija', 'Luksemburg', 'Malta',
            'Moldavija', 'Monako', 'Crna Gora', 'Holandija', 'Severna Makedonija',
            'Norveška', 'Poljska', 'Portugalija', 'Rumunija', 'Rusija',
            'San Marino', 'Srbija', 'Slovačka', 'Slovenija', 'Španija',
            'Švedska', 'Švajcarska', 'Turska', 'Ukrajina', 'Ujedinjeno Kraljevstvo',
            'Vatikan'
        ];

        foreach ($drzave as $drzava) {
            \DB::table('drzava')->insert([
                'naziv' => $drzava,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
