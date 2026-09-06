<!DOCTYPE html>
<html lang="sr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
    h2 { font-size: 15px; margin-bottom: 4px; }
    .meta { font-size: 10px; color: #555; margin-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background-color: #1a5f7a; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e0e0e0; vertical-align: top; }
    tr:nth-child(even) td { background-color: #f7f7f7; }
    .footer { margin-top: 16px; font-size: 9px; color: #999; text-align: right; }
    .badge { padding: 2px 6px; border-radius: 3px; font-size: 9px; }
    .badge-nova { background:#ffc107; color:#333; }
    .badge-potv { background:#198754; color:#fff; }
    .badge-otk  { background:#dc3545; color:#fff; }
</style>
</head>
<body>

<h2>Spisak putnika — {{ $putovanje->naziv }}</h2>
<div class="meta">
    {{ $putovanje->drzava->naziv ?? '' }}{{ $putovanje->grad ? ', ' . $putovanje->grad : '' }}
    | Prevoz: {{ $putovanje->tipPrevoza->naziv ?? 'N/A' }}
    | Generisano: {{ now()->format('d.m.Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Ime i prezime</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Termin</th>
            <th>Odrasli</th>
            <th>Deca</th>
            <th>Tip sobe</th>
            <th>Status</th>
            <th>Ukupna cena</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rezervacije as $rez)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $rez->puno_ime }}</td>
            <td>{{ $rez->email }}</td>
            <td>{{ $rez->telefon }}</td>
            <td>
                @if($rez->termin)
                    {{ $rez->termin->datum_od->format('d.m.Y') }} – {{ $rez->termin->datum_do->format('d.m.Y') }}
                @else —
                @endif
            </td>
            <td>{{ $rez->broj_odraslih }}</td>
            <td>{{ $rez->broj_dece ?? 0 }}</td>
            <td>{{ $rez->tipSobe->naziv ?? '—' }}</td>
            <td>
                <span class="badge {{ $rez->status === \App\Enums\StatusRezervacije::Potvrdjena ? 'badge-potv' : ($rez->status === \App\Enums\StatusRezervacije::Otkazana ? 'badge-otk' : 'badge-nova') }}">
                    {{ $rez->status->label() }}
                </span>
            </td>
            <td>{{ number_format($rez->ukupna_cena, 2) }} €</td>
        </tr>
        @empty
        <tr><td colspan="10" style="text-align:center;color:#999;">Nema putnika.</td></tr>
        @endforelse
    </tbody>
    @if($rezervacije->count() > 0)
    <tfoot>
        <tr>
            <td colspan="5"><strong>Ukupno: {{ $rezervacije->count() }} rezervacija</strong></td>
            <td><strong>{{ $rezervacije->sum('broj_odraslih') }}</strong></td>
            <td><strong>{{ $rezervacije->sum('broj_dece') }}</strong></td>
            <td colspan="2"></td>
            <td><strong>{{ number_format($rezervacije->sum('ukupna_cena'), 2) }} €</strong></td>
        </tr>
    </tfoot>
    @endif
</table>

<div class="footer">{{ config('app.name') }} &mdash; {{ config('app.url') }}</div>
</body>
</html>
