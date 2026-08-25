@foreach($termini as $termin)
    <div>{{ \Carbon\Carbon::parse($termin['datum_od'])->format('d.m.Y.') }} &ndash; {{ \Carbon\Carbon::parse($termin['datum_do'])->format('d.m.Y.') }} ({{ $termin['broj_dostupnih_mesta'] }} mesta)</div>
@endforeach
