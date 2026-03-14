@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ isset($putovanje->id) ? 'Izmena putovanja' : 'Novo putovanje' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($putovanje->id) ? route('putovanja.update', $putovanje->id) : route('putovanja.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($putovanje->id))
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-6">
                    <x-input-text label="{{ __('Naziv') }}" name="naziv" :value="$putovanje->naziv ?? old('naziv')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-select label="{{ __('Država') }}" name="id_drzave" :items="$drzave" :value="$putovanje->id_drzave ?? old('id_drzave')" :emptyOption="true" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Grad') }}" name="grad" :value="$putovanje->grad ?? old('grad')" :required="true" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <x-input-text label="{{ __('Mesto polaska') }}" name="mesto_polaska" :value="$putovanje->mesto_polaska ?? old('mesto_polaska')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-flatpickr label="{{ __('Datum od') }}" name="datum_od" :value="$putovanje->datum_od ?? old('datum_od')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-flatpickr label="{{ __('Datum do') }}" name="datum_do" :value="$putovanje->datum_do ?? old('datum_do')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Cena (EUR)') }}" name="cena" type="number" step="0.01" :value="$putovanje->cena ?? old('cena')" :required="true" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <x-input-text label="{{ __('Broj dana') }}" name="broj_dana" type="number" :value="$putovanje->broj_dana ?? old('broj_dana')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Broj noćenja') }}" name="broj_nocenja" type="number" :value="$putovanje->broj_nocenja ?? old('broj_nocenja')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Dostupna mesta') }}" name="broj_dostupnih_mesta" type="number" :value="$putovanje->broj_dostupnih_mesta ?? old('broj_dostupnih_mesta')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-select label="{{ __('Tip prevoza') }}" name="id_tip_prevoza" :items="$tip_prevoza" :value="$putovanje->id_tip_prevoza ?? old('id_tip_prevoza')" :required="true" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <x-input-text label="{{ __('Prevoznik') }}" name="prevoznik" :value="$putovanje->prevoznik ?? old('prevoznik')" />
                </div>
                <div class="col-md-4">
                    <x-input-select label="{{ __('Hotel') }}" name="id_hotela" :items="$hoteli" :value="$putovanje->id_hotela ?? old('id_hotela')" :emptyOption="true" />
                </div>
                <div class="col-md-4">
                    <x-input-select label="{{ __('Tip sobe') }}" name="id_tip_sobe" :items="$tip_sobe" :value="$putovanje->id_tip_sobe ?? old('id_tip_sobe')" :emptyOption="true" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <x-input-textarea label="{{ __('Program putovanja') }}" name="program_putovanja" :value="$putovanje->program_putovanja ?? old('program_putovanja')" rows="5" :required="true" />
                </div>
                <div class="col-md-6">
                    <x-input-textarea label="{{ __('Fakultativni izleti') }}" name="fakultativni_izleti" :value="$putovanje->fakultativni_izleti ?? old('fakultativni_izleti')" rows="5" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <x-input-textarea label="{{ __('Pravila otkazivanja') }}" name="pravila_otkazivanja" :value="$putovanje->pravila_otkazivanja ?? old('pravila_otkazivanja')" rows="3" />
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn button-primary">
                    <i class="fa fa-save"></i> {{ __('Sačuvaj') }}
                </button>
                <a href="{{ route('putovanja.index') }}" class="btn btn-secondary">
                    <i class="fa fa-times"></i> {{ __('Otkaži') }}
                </a>
            </div>
        </form>
    </div>
</div>

@endsection