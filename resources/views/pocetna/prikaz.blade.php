@extends('layouts.app')

@section('content')
<div class="container" style="padding-top:80px;">
    @include('includes.message_alert')
    <div class="mb-3">
        <a href="{{ route('pocetna') }}#putovanja" class="btn button-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Nazad na putovanja
        </a>
    </div>
    {{-- Hero slika --}}
    <div class="row mb-4">
        <div class="col-md-12">
            @if($putovanje->slike->isNotEmpty())
            <img src="{{ asset('storage/putovanja/' . $putovanje->id . '/slike/' . $putovanje->slike->first()->slika) }}"
                 class="img-fluid w-100" alt="{{ $putovanje->naziv }}">
            @else
            <img src="{{ asset('images/alps.png') }}"
                 class="img-fluid w-100" alt="{{ $putovanje->naziv }}">
            @endif
        </div>
    </div>

    <div class="row">
        {{-- Leva kolona --}}
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title text-primary">{{ $putovanje->naziv }}</h2>
                    <p class="text-muted">
                        <i class="fa fa-map-marker me-1"></i> {{ $putovanje->drzava->naziv ?? '' }}, {{ $putovanje->grad }}
                    </p>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fa fa-clock-o me-1"></i> Trajanje:</strong> {{ $putovanje->broj_dana }} dana / {{ $putovanje->broj_nocenja }} noćenja</p>
                            <p><strong><i class="fa fa-{{ strtolower($putovanje->tipPrevoza->naziv ?? '') === 'avion' ? 'plane' : 'bus' }} me-1"></i> Prevoz:</strong>
                                {{ $putovanje->tipPrevoza->naziv ?? 'N/A' }} ({{ $putovanje->prevoznik ?? 'N/A' }})
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if($putovanje->hotel)
                            <p><strong><i class="fa fa-bed me-1"></i> Hotel:</strong>
                                {{ $putovanje->hotel->naziv }}
                                @for($i = 0; $i < $putovanje->hotel->broj_zvezdica; $i++)
                                    <i class="fa fa-star text-warning" style="font-size:.8rem;"></i>
                                @endfor
                            </p>
                            <p class="text-muted small">{{ $putovanje->hotel->adresa }}, {{ $putovanje->hotel->grad }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Termini --}}
                    @if(count($termini) > 0)
                    <h5 class="mt-3"><i class="fa fa-calendar me-1"></i> Termini putovanja</h5>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($termini as $termin)
                        <li class="list-group-item px-0">
                            {{ $termin['datum_od'] }} &ndash; {{ $termin['datum_do'] }}
                            <span class="badge bg-secondary ms-2">{{ $termin['broj_dostupnih_mesta'] }} mesta</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <h5 class="mt-4 text-primary">Program putovanja</h5>
                    <div class="card bg-light mb-3">
                        <div class="card-body">{!! nl2br(e($putovanje->program_putovanja)) !!}</div>
                    </div>

                    @if($putovanje->fakultativni_izleti)
                    <h5 class="mt-3 text-primary">Fakultativni izleti</h5>
                    <div class="card bg-light mb-3">
                        <div class="card-body">{!! nl2br(e($putovanje->fakultativni_izleti)) !!}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Desna kolona - cena i rezervacija --}}
        <div class="col-md-4">
            <div class="card shadow-lg sticky-top mb-3" style="top:20px;">
                <div class="card-header text-white text-center">
                    <h3 class="mb-0">{{ number_format($putovanje->cena, 2) }} €</h3>
                    <small>po osobi</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('rezervacije.store.javno') }}" novalidate>
                        @csrf
                        <input type="hidden" name="id_putovanja" value="{{ $putovanje->id }}">

                        <x-input-select
                            name="id_termina"
                            label="Termin putovanja"
                            :items="collect($termini)->map(fn($t) => ['id' => $t['id'], 'text' => $t['datum_od'] . ' – ' . $t['datum_do'] . ' (' . $t['broj_dostupnih_mesta'] . ' mesta)'])->values()->toArray()"
                            :emptyOption="true"
                            :required="true"
                        />

                        <x-input-text name="puno_ime" label="Ime i prezime" :required="true" />
                        <x-input-text name="email" label="Email adresa" :required="true" />
                        <x-input-text name="telefon" label="Telefon" :required="true" />

                        <div class="row">
                            <div class="col-6">
                                <x-input-number name="broj_odraslih" label="Odrasli" :value="1" :required="true" />
                            </div>
                            <div class="col-6">
                                <x-input-number name="broj_dece" label="Deca" :value="0" />
                            </div>
                        </div>

                        @if(count($tip_sobe) > 0)
                        <x-input-select name="id_tip_sobe" label="Tip sobe" :items="$tip_sobe" :emptyOption="true" />
                        @endif

                        <x-input-textarea name="napomena" label="Napomena" />

                        <div class="alert alert-info small mb-3">
                            <i class="fa fa-info-circle me-1"></i> Potvrda rezervacije biće poslata na Vaš email.
                        </div>

                        <button type="submit" class="btn button-primary w-100 btn-lg">
                            Rezerviši
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
