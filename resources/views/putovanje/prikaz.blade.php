@extends('layouts.app')

@section('content')
    <x-tabs>

        <x-tab name="detalji" label="{{ __('Detalji putovanja') }}" :active="true">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $putovanje->naziv }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-text label="{{ __('Naziv') }}" name="naziv" :value="$putovanje->naziv" :readonly="true" />
                        </div>
                        <div class="col-md-3">
                            <x-input-select label="{{ __('Država') }}" name="id_drzave" :items="$drzave" :value="$putovanje->id_drzave" :readonly="true" />
                        </div>
                        <div class="col-md-3">
                            <x-input-text label="{{ __('Grad') }}" name="grad" :value="$putovanje->grad" :readonly="true" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="label-select"><b>{{ __('Termini putovanja') }}</b></label>
                            <div>
                                @foreach($termini as $termin)
                                <div class="termin-row row mb-2 align-items-end">
                                    <div class="col-md-3">
                                        <div class="form-field">
                                            <label class="label-select">{{ __('Datum od') }}</label>
                                            <input type="text" class="form-control" value="{{ $termin['datum_od'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-field">
                                            <label class="label-select">{{ __('Datum do') }}</label>
                                            <input type="text" class="form-control" value="{{ $termin['datum_do'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-field">
                                            <label class="label-select">{{ __('Dostupna mesta') }}</label>
                                            <input type="number" class="form-control" value="{{ $termin['broj_dostupnih_mesta'] }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <x-input-text label="{{ __('Cena (EUR)') }}" name="cena" type="number" step="0.01" :value="$putovanje->cena" :readonly="true" />
                        </div>
                        <div class="col-md-3">
                            <x-input-text label="{{ __('Broj dana') }}" name="broj_dana" type="number" :value="$putovanje->broj_dana" :readonly="true" />
                        </div>
                        <div class="col-md-3">
                            <x-input-text label="{{ __('Broj noćenja') }}" name="broj_nocenja" type="number" :value="$putovanje->broj_nocenja" :readonly="true" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <x-input-select label="{{ __('Tip prevoza') }}" name="id_tip_prevoza" :items="$tip_prevoza" :value="$putovanje->id_tip_prevoza" :readonly="true" />
                        </div>
                        <div class="col-md-3">
                            <x-input-text label="{{ __('Prevoznik') }}" name="prevoznik" :value="$putovanje->prevoznik" :readonly="true" />
                        </div>
                        <div class="col-md-3">
                            <x-input-select label="{{ __('Hotel') }}" name="id_hotela" :items="$hoteli" :value="$putovanje->id_hotela" :readonly="true" :emptyOption="true" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <x-input-textarea label="{{ __('Program putovanja') }}" name="program_putovanja" :value="$putovanje->program_putovanja" rows="5" :readonly="true" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <x-input-textarea label="{{ __('Fakultativni izleti') }}" name="fakultativni_izleti" :value="$putovanje->fakultativni_izleti" rows="5" :readonly="true" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <x-input-textarea label="{{ __('Pravila otkazivanja') }}" name="pravila_otkazivanja" :value="$putovanje->pravila_otkazivanja" rows="3" :readonly="true" />
                        </div>
                    </div>

                    @if($putovanje->slike->isNotEmpty())
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="label-select"><b>{{ __('Galerija slika') }}</b></label>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                @foreach($putovanje->slike as $slika)
                                <a href="{{ asset('storage/' . $slika->slika) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $slika->slika) }}"
                                         style="height: 120px; width: 160px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;"
                                         alt="{{ $putovanje->naziv }}">
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('putovanja.edit', $putovanje->id) }}" class="btn button-primary">
                            {{ __('Izmeni') }}
                        </a>
                        <a href="{{ route('putovanja.index') }}" class="btn button-secondary">
                         {{ __('Nazad') }}
                        </a>
                    </div>
                </div>
            </div>
        </x-tab>

        @auth
        <x-tab name="putnici" label="{{ __('Putnici') }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Rezervacije</h4>
                    <a href="{{ route('putovanja.putnici_pdf', $putovanje->id) }}" class="btn button-primary btn-sm" target="_blank">
                        <i class="fa fa-file-pdf-o me-1"></i> {{ __('PDF') }}
                    </a>
                </div>
                <div class="card-body p-0">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Ime i prezime</th>
                                    <th>Email</th>
                                    <th>Telefon</th>
                                    <th>Odrasli</th>
                                    <th>Deca</th>
                                    <th>Tip sobe</th>
                                    <th>Status</th>
                                    <th>Ukupna cena</th>
                                    <th>Napomena</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rezervacije as $rez)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rez->puno_ime }}</td>
                                    <td>{{ $rez->email }}</td>
                                    <td>{{ $rez->telefon }}</td>
                                    <td class="text-center">{{ $rez->broj_odraslih }}</td>
                                    <td class="text-center">{{ $rez->broj_dece }}</td>
                                    <td>{{ $rez->tipSobe->naziv ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $rez->status->boja() }}">
                                            {{ $rez->status->label() }}
                                        </span>
                                    </td>
                                    <td>{{ $rez->ukupna_cena ? number_format($rez->ukupna_cena, 2) . ' €' : '-' }}</td>
                                    <td>{{ $rez->napomena ?: '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="fa fa-users"></i> Nema prijavljenih putnika za ovo putovanje.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($rezervacije->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="4">Ukupno: {{ $rezervacije->count() }} rezervacija</th>
                                    <th class="text-center">{{ $rezervacije->sum('broj_odraslih') }}</th>
                                    <th class="text-center">{{ $rezervacije->sum('broj_dece') }}</th>
                                    <th colspan="2"></th>
                                    <th>{{ number_format($rezervacije->sum('ukupna_cena'), 2) }} €</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </x-tab>
        @endauth

    </x-tabs>
@endsection
