@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Hero sekcija --}}
    <div class="row mb-4">
        <div class="col-md-12">
            @if($putovanje->baner_slika)
                <img src="{{ asset('storage/' . $putovanje->baner_slika) }}" class="img-fluid w-100" style="max-height: 400px; object-fit: cover; border-radius: 10px;" alt="{{ $putovanje->naziv }}">
            @else
                <img src="{{ asset('images/alps.png') }}" class="img-fluid w-100" style="max-height: 400px; object-fit: cover; border-radius: 10px;" alt="{{ $putovanje->naziv }}">
            @endif
        </div>
    </div>

    <div class="row">
        {{-- Leva kolona - Detalji putovanja --}}
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title text-primary">{{ $putovanje->naziv }}</h2>
                    <p class="text-muted">
                        <i class="fa fa-map-marker"></i> {{ $putovanje->drzava->naziv ?? '' }}, {{ $putovanje->grad }}
                    </p>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fa fa-calendar"></i> Datum polaska:</strong> {{ $putovanje->datum_od ? $putovanje->datum_od->format('d.m.Y') : 'N/A' }}</p>
                            <p><strong><i class="fa fa-calendar"></i> Datum povratka:</strong> {{ $putovanje->datum_do ? $putovanje->datum_do->format('d.m.Y') : 'N/A' }}</p>
                            <p><strong><i class="fa fa-clock-o"></i> Trajanje:</strong> {{ $putovanje->broj_dana }} dana / {{ $putovanje->broj_nocenja }} noćenja</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fa fa-map-signs"></i> Polazak iz:</strong> {{ $putovanje->mesto_polaska }}</p>
                            <p><strong><i class="fa fa-bus"></i> Prevoz:</strong> {{ $putovanje->tipPrevoza->naziv ?? 'N/A' }} ({{ $putovanje->prevoznik ?? 'N/A' }})</p>
                            <p><strong><i class="fa fa-users"></i> Dostupna mesta:</strong> {{ $putovanje->broj_dostupnih_mesta }}</p>
                        </div>
                    </div>

                    @if($putovanje->hotel)
                    <div class="alert alert-info">
                        <h5><i class="fa fa-bed"></i> Smeštaj</h5>
                        <p><strong>Hotel:</strong> {{ $putovanje->hotel->naziv }} ({{ $putovanje->hotel->broj_zvezdica }} <i class="fa fa-star text-warning"></i>)</p>
                        <p><strong>Adresa:</strong> {{ $putovanje->hotel->adresa }}, {{ $putovanje->hotel->grad }}</p>
                    </div>
                    @endif

                    <h4 class="mt-4 text-primary">Program putovanja</h4>
                    <div class="card bg-light">
                        <div class="card-body">
                            {!! nl2br(e($putovanje->program_putovanja)) !!}
                        </div>
                    </div>

                    @if($putovanje->fakultativni_izleti)
                    <h4 class="mt-4 text-primary">Fakultativni izleti</h4>
                    <div class="card bg-light">
                        <div class="card-body">
                            {!! nl2br(e($putovanje->fakultativni_izleti)) !!}
                        </div>
                    </div>
                    @endif

                    @if($putovanje->pravila_otkazivanja)
                    <h4 class="mt-4 text-primary">Pravila otkazivanja</h4>
                    <div class="card bg-light">
                        <div class="card-body">
                            {!! nl2br(e($putovanje->pravila_otkazivanja)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Desna kolona - Cena i Rezervacija --}}
        <div class="col-md-4">
            @guest
            {{-- Kartica sa cenom i rezervacijom - vidljiva samo za goste --}}
            <div class="card shadow-lg sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">{{ number_format($putovanje->cena, 2) }} €</h3>
                    <small>po osobi</small>
                </div>
                
                <div class="card-body">
                    <h5 class="text-center mb-3">Rezervišite sada!</h5>
                    
                    <form method="POST" action="{{ route('rezervacije.store') }}" id="rezervacijaForm">
                        @csrf
                        <input type="hidden" name="id_putovanja" value="{{ $putovanje->id }}">
                        <input type="hidden" name="termin" value="{{ $putovanje->datum_od ? $putovanje->datum_od->format('d.m.Y') : '' }} - {{ $putovanje->datum_do ? $putovanje->datum_do->format('d.m.Y') : '' }}">

                        <div class="mb-3">
                            <label for="puno_ime" class="form-label">Ime i prezime *</label>
                            <input type="text" class="form-control @error('puno_ime') is-invalid @enderror" id="puno_ime" name="puno_ime" value="{{ old('puno_ime') }}" required>
                            @error('puno_ime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefon" class="form-label">Telefon *</label>
                            <input type="text" class="form-control @error('telefon') is-invalid @enderror" id="telefon" name="telefon" value="{{ old('telefon') }}" required>
                            @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="broj_odraslih" class="form-label">Odrasli *</label>
                                <input type="number" class="form-control @error('broj_odraslih') is-invalid @enderror" id="broj_odraslih" name="broj_odraslih" value="{{ old('broj_odraslih', 1) }}" min="1" required>
                                @error('broj_odraslih')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label for="broj_dece" class="form-label">Deca</label>
                                <input type="number" class="form-control @error('broj_dece') is-invalid @enderror" id="broj_dece" name="broj_dece" value="{{ old('broj_dece', 0) }}" min="0">
                                @error('broj_dece')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if($tip_sobe->count() > 0)
                        <div class="mb-3">
                            <label for="id_tip_sobe" class="form-label">Tip sobe</label>
                            <select class="form-select" id="id_tip_sobe" name="id_tip_sobe">
                                <option value="">Izaberite tip sobe</option>
                                @foreach($tip_sobe as $soba)
                                    <option value="{{ $soba['id'] }}">{{ $soba['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="napomena" class="form-label">Napomena</label>
                            <textarea class="form-control" id="napomena" name="napomena" rows="2">{{ old('napomena') }}</textarea>
                        </div>

                        <div class="alert alert-info small mb-3">
                            <i class="fa fa-info-circle"></i> Potvrda rezervacije će biti poslata na Vaš email.
                        </div>

                        <button type="submit" class="btn button-primary w-100 btn-lg">
                            <i class="fa fa-check"></i> Rezerviši
                        </button>
                    </form>
                </div>
            </div>
            @endguest

            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-0"><i class="fa fa-users"></i> <strong>{{ $putovanje->broj_rezervacija }}</strong> rezervacija</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
