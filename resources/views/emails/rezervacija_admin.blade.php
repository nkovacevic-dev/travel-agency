<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova rezervacija</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
        }

        td {
            padding: 6px 0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Nova rezervacija</h2>
    <p>Stigla je nova rezervacija sa sajta.</p>

    <table>
        <tr>
            <td>Putovanje:</td>
            <td>{{ $rezervacija->putovanje->naziv ?? '' }}</td>
        </tr>
        @if($rezervacija->termin)
        <tr>
            <td>Termin:</td>
            <td>{{ $rezervacija->termin->datum_od->format('d.m.Y.') }} - {{ $rezervacija->termin->datum_do->format('d.m.Y.') }}</td>
        </tr>
        @endif
        <tr>
            <td>Ime:</td>
            <td>{{ $rezervacija->puno_ime }}</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>{{ $rezervacija->email }}</td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td>{{ $rezervacija->telefon }}</td>
        </tr>
        <tr>
            <td>Odrasli:</td>
            <td>{{ $rezervacija->broj_odraslih }}</td>
        </tr>
        <tr>
            <td>Deca:</td>
            <td>{{ $rezervacija->broj_dece ?? 0 }}</td>
        </tr>
        <tr>
            <td>Ukupna cena:</td>
            <td>{{ number_format($rezervacija->ukupna_cena, 2) }} €</td>
        </tr>
        @if($rezervacija->napomena)
        <tr>
            <td>Napomena:</td>
            <td>{{ $rezervacija->napomena }}</td>
        </tr>
        @endif
    </table>
</body>

</html>