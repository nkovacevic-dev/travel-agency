<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class PravilaService
{
    private array $pravila;

    public function __construct()
    {
        $this->pravila = json_decode(File::get(config_path('rezervacija_pravila.json')), true);
    }

    public function maxOdraslih(): int
    {
        return $this->pravila['rezervacija']['max_odraslih'];
    }

    public function maxDece(): int
    {
        return $this->pravila['rezervacija']['max_dece'];
    }

    public function maxUkupnoPutnika(): int
    {
        return $this->pravila['rezervacija']['max_ukupno_putnika'];
    }

    public function minDanaUnapred(): int
    {
        return $this->pravila['rezervacija']['min_dana_unapred'];
    }

    public function popustDeceProcenat(): int
    {
        return $this->pravila['rezervacija']['popust_deca_procenat'];
    }

    /** Vraća procenat kazne na osnovu broja dana do polaska. */
    public function kaznaOtkazivanja(int $danaPre): int
    {
        // Pravila sortirana opadajuće – prvi prag koji je <= danaPre se primenjuje
        $sortiranaPravila = collect($this->pravila['otkazivanje']['pravila'])
            ->sortByDesc('dana_pre_od');

        foreach ($sortiranaPravila as $pravilo) {
            if ($danaPre >= $pravilo['dana_pre_od']) {
                return $pravilo['kazna_procenat'];
            }
        }

        return 100;
    }
}
