@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Detalji rezervacije #{{ $rezervacija->id }}</h4>
        <div>
            <a href="{{ route('rezervacije.edit', $rezervacija->id) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> {{ __('Izmeni') }}
            </a>
            <a href="{{ route('rezervacije.index') }}" class="btn button-outline-primary">
                 {{ __('Nazad') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary">Informacije o putniku</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Ime i prezime:</th>
                        <td>{{ $rezervacija->puno_ime }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $rezervacija->email }}</td>
                    </tr>
                    <tr>
                        <th>Telefon:</th>
                        <td>{{ $rezervacija->telefon }}</td>
                    </tr>
                    <tr>
                        <th>Broj odraslih:</th>
                        <td>{{ $rezervacija->broj_odraslih }}</td>
                    </tr>
                    <tr>
                        <th>Broj dece:</th>
                        <td>{{ $rezervacija->broj_dece }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <h5 class="text-primary">Informacije o putovanju</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Putovanje:</th>
                        <td>{{ $rezervacija->putovanje->naziv ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Termin:</th>
                        <td>{{ $rezervacija->termin }}</td>
                    </tr>
                    <tr>
                        <th>Hotel:</th>
                        <td>{{ $rezervacija->hotel->naziv ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tip sobe:</th>
                        <td>{{ $rezervacija->tipSobe->naziv ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-{{ $rezervacija->status == 'potvrđena' ? 'success' : ($rezervacija->status == 'otkazana' ? 'danger' : 'warning') }}">
                                {{ ucfirst($rezervacija->status ?? 'nova') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <h5 class="text-primary">Dodatne informacije</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="20%">Ukupna cena:</th>
                        <td><strong>{{ number_format($rezervacija->ukupna_cena ?? 0, 2) }} €</strong></td>
                    </tr>
                    <tr>
                        <th>Napomena:</th>
                        <td>{{ $rezervacija->napomena ?? 'Nema napomene' }}</td>
                    </tr>
                    <tr>
                        <th>Datum kreiranja:</th>
                        <td>{{ $rezervacija->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Poslednja izmena:</th>
                        <td>{{ $rezervacija->updated_at->format('d.m.Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
