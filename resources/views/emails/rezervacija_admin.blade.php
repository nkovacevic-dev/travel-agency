<!DOCTYPE html>
<html>
<body style="font-family:Arial,sans-serif;color:#333;">
<h2>Nova rezervacija</h2>
<p>Stigla je nova rezervacija sa sajta.</p>

<table style="border-collapse:collapse;width:100%;max-width:600px;">
    <tr><td style="padding:6px 0;font-weight:bold;width:160px;">Putovanje:</td><td>{{ $rezervacija->putovanje->naziv ?? '' }}</td></tr>
    @if($rezervacija->termin)
    <tr><td style="padding:6px 0;font-weight:bold;">Termin:</td><td>{{ $rezervacija->termin->datum_od->format('d.m.Y.') }} – {{ $rezervacija->termin->datum_do->format('d.m.Y.') }}</td></tr>
    @endif
    <tr><td style="padding:6px 0;font-weight:bold;">Ime:</td><td>{{ $rezervacija->puno_ime }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Email:</td><td>{{ $rezervacija->email }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Telefon:</td><td>{{ $rezervacija->telefon }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Odrasli:</td><td>{{ $rezervacija->broj_odraslih }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Deca:</td><td>{{ $rezervacija->broj_dece ?? 0 }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Ukupna cena:</td><td>{{ number_format($rezervacija->ukupna_cena, 2) }} €</td></tr>
    @if($rezervacija->napomena)
    <tr><td style="padding:6px 0;font-weight:bold;">Napomena:</td><td>{{ $rezervacija->napomena }}</td></tr>
    @endif
</table>
</body>
</html>
