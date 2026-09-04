@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Otkazivanje rezervacije #{{ $rezervacija->id }}</h4>
        <a href="{{ route('rezervacije.show', $rezervacija->id) }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Nazad
        </a>
    </div>
    <div class="card-body">

        @if(session('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif

        <div class="alert alert-warning">
            <strong><i class="fa fa-exclamation-triangle"></i> Upozorenje:</strong>
            Ovo je trajna akcija. Rezervacija će biti označena kao otkazana i ne može se ponovo aktivirati.
        </div>

        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary">Detalji rezervacije</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="45%">Putnik:</th>
                        <td>{{ $rezervacija->puno_ime }}</td>
                    </tr>
                    <tr>
                        <th>Putovanje:</th>
                        <td>{{ $rezervacija->putovanje->naziv ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Termin polaska:</th>
                        <td>{{ $rezervacija->termin->datum_od->format('d.m.Y.') }}</td>
                    </tr>
                    <tr>
                        <th>Ukupna cena:</th>
                        <td><strong>{{ number_format($rezervacija->ukupna_cena, 2) }} €</strong></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <h5 class="text-danger">Izračun kaznene naknade</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="55%">Dana do polaska:</th>
                        <td>{{ $danaPre }} dana</td>
                    </tr>
                    <tr>
                        <th>Procenat kazne:</th>
                        <td>
                            <span class="badge bg-{{ $kaznaProcenat == 0 ? 'success' : ($kaznaProcenat < 50 ? 'warning' : 'danger') }} fs-6">
                                {{ $kaznaProcenat }}%
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Kaznena naknada:</th>
                        <td class="text-danger fw-bold">- {{ number_format($kaznaCena, 2) }} €</td>
                    </tr>
                    <tr class="table-success">
                        <th>Povratni iznos klijentu:</th>
                        <td class="fw-bold">{{ number_format($povratnaCena, 2) }} €</td>
                    </tr>
                </table>

                <div class="alert alert-info mt-2 small">
                    <strong>Pravila otkazivanja:</strong><br>
                    ≥ 30 dana pre polaska → 0% kazne<br>
                    15 - 29 dana pre polaska → 25% kazne<br>
                    7 - 14 dana pre polaska → 50% kazne<br>
                    0 - 6 dana pre polaska → 100% kazne
                </div>
            </div>
        </div>

        <hr>
        <form method="POST" action="{{ route('rezervacije.potvrdiOtkazivanje', $rezervacija->id) }}">
            @csrf
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Da li ste sigurni da želite da otkažete ovu rezervaciju?')">
                     Potvrdi otkazivanje
                </button>
                <a href="{{ route('rezervacije.show', $rezervacija->id) }}" class="btn button-secondary">
                    Odustani
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
