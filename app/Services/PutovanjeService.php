<?php

namespace App\Services;

use App\Models\Putovanje;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PutovanjeService
{
    public function sacuvajSlike(Putovanje $putovanje, array $files): void
    {
        foreach ($files as $file) {
            $filename = basename($file->store('putovanja/' . $putovanje->id . '/slike', 'public'));
            $putovanje->slike()->create(['slika' => $filename]);
        }
    }

    public function obrisiSlike(Putovanje $putovanje): void
    {
        foreach ($putovanje->slike as $slika) {
            Storage::disk('public')->delete('putovanja/' . $putovanje->id . '/slike/' . $slika->slika);
        }
        $putovanje->slike()->delete();
    }

    public function sacuvajTermine(Putovanje $putovanje, array $termini): void
    {
        foreach ($termini as $termin) {
            $putovanje->termini()->create([
                'datum_od'             => Carbon::createFromFormat('d.m.Y.', $termin['datum_od']),
                'datum_do'             => Carbon::createFromFormat('d.m.Y.', $termin['datum_do']),
                'broj_dostupnih_mesta' => $termin['broj_dostupnih_mesta'],
            ]);
        }
    }

    public function generisiPdfPutnici(Putovanje $putovanje, $rezervacije): \Barryvdh\DomPDF\PDF
    {
        $pdf = Pdf::loadView('putovanje.spisak_putnika_pdf', compact('putovanje', 'rezervacije'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf;
    }
}
