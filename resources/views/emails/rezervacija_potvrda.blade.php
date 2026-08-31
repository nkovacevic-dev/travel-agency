<!DOCTYPE html>
<html>
<body style="font-family:Arial,sans-serif;color:#333;">
<h2>Potvrda rezervacije</h2>
<p>Poštovani/a <strong>{{ $rezervacija->puno_ime }}</strong>,</p>
<p>Vaša rezervacija je uspešno primljena. U nastavku su detalji:</p>

<table style="border-collapse:collapse;width:100%;max-width:600px;">
    <tr><td style="padding:6px 0;font-weight:bold;width:160px;">Putovanje:</td><td>{{ $rezervacija->putovanje->naziv ?? '' }}</td></tr>
    @if($rezervacija->termin)
    <tr><td style="padding:6px 0;font-weight:bold;">Termin:</td><td>{{ $rezervacija->termin->datum_od->format('d.m.Y.') }} – {{ $rezervacija->termin->datum_do->format('d.m.Y.') }}</td></tr>
    @endif
    <tr><td style="padding:6px 0;font-weight:bold;">Odrasli:</td><td>{{ $rezervacija->broj_odraslih }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Deca:</td><td>{{ $rezervacija->broj_dece ?? 0 }}</td></tr>
    <tr><td style="padding:6px 0;font-weight:bold;">Ukupna cena:</td><td>{{ number_format($rezervacija->ukupna_cena, 2) }} €</td></tr>
    @if($rezervacija->napomena)
    <tr><td style="padding:6px 0;font-weight:bold;">Napomena:</td><td>{{ $rezervacija->napomena }}</td></tr>
    @endif
</table>

<p style="margin-top:20px;">Kontaktiraćemo Vas u najkraćem roku radi potvrde i daljnjih informacija.</p>
<p>Hvala na poverenju!<br><strong>{{ config('app.name') }}</strong></p>
</body>
</html>
