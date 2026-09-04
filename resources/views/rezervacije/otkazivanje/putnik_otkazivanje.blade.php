@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-start min-vh-100 py-5 bg-light">
    <div class="card shadow" style="max-width:620px; width:100%;">
        <div class="card-header bg-white">
            <h5 class="mb-0">Otkazivanje rezervacije</h5>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                </div>
                <p class="text-muted">Biće Vam vraćen iznos od <strong>{{ number_format(session('povratnaCena', $povratnaCena ?? 0), 2) }} €</strong> u roku od 5–7 radnih dana.</p>
                <a href="{{ route('pocetna') }}" class="btn btn-outline-primary mt-2">Nazad na početnu</a>
            @elseif(!empty($vec_otkazana))
                <div class="alert alert-info">
                    Ova rezervacija je već otkazana.
                </div>
                <a href="{{ route('pocetna') }}" class="btn button-secondary mt-2">Nazad na početnu</a>
            @else
                <p class="text-muted mb-3">Pregledajte detalje rezervacije i izračun kaznene naknade pre potvrde.</p>

                <table class="table table-bordered mb-4">
                    <tr>
                        <th width="45%">Putnik:</th>
                        <td>{{ $rezervacija->puno_ime }}</td>
                    </tr>
                    <tr>
                        <th>Putovanje:</th>
                        <td>{{ $rezervacija->putovanje->naziv ?? 'N/A' }}</td>
                    </tr>
                    @if($rezervacija->termin)
                    <tr>
                        <th>Termin polaska:</th>
                        <td>{{ $rezervacija->termin->datum_od->format('d.m.Y.') }} -{{ $rezervacija->termin->datum_do->format('d.m.Y.') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Ukupna cena:</th>
                        <td><strong>{{ number_format($rezervacija->ukupna_cena, 2) }} €</strong></td>
                    </tr>
                </table>

                <div class="card mb-4 border-{{ $kaznaProcenat == 0 ? 'success' : ($kaznaProcenat < 50 ? 'warning' : 'danger') }}">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Kaznena naknada</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Dana do polaska:</span>
                            <strong>{{ $danaPre }} dana</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Procenat kazne:</span>
                            <span class="badge bg-{{ $kaznaProcenat == 0 ? 'success' : ($kaznaProcenat < 50 ? 'warning' : 'danger') }} fs-6">{{ $kaznaProcenat }}%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-danger">
                            <span>Kaznena naknada:</span>
                            <strong>- {{ number_format($kaznaCena, 2) }} €</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between text-success fw-bold">
                            <span>Povratni iznos:</span>
                            <span>{{ number_format($povratnaCena, 2) }} €</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning small">
                    <i class="fa fa-exclamation-triangle me-1"></i>
                    <strong>Ovo je trajna akcija.</strong> Nakon potvrde rezervacija ne može biti ponovo aktivirana.
                </div>

                <form id="otkazivanje-form" method="POST" action="{{ route('rezervacije.javno.potvrdiOtkazivanje', $token) }}">
                    @csrf
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">
                            Potvrdi otkazivanje
                        </button>
                        <a href="{{ route('pocetna') }}" class="btn button-secondary">Odustani</a>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>

@section('content_scripts')
<script>
    document.getElementById('otkazivanje-form')?.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Da li ste sigurni?',
            text: 'Otkazivanje rezervacije je trajno i ne može se poništiti.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Da, otkaži rezervaciju',
            cancelButtonText: 'Odustani',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endsection
@endsection
