@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ isset($hotel->id) ? 'Izmena hotela' : 'Novi hotel' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($hotel->id) ? route('hoteli.update', $hotel->id) : route('hoteli.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($hotel->id))
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-6">
                    <x-input-text label="{{ __('Naziv') }}" name="naziv" :value="$hotel->naziv ?? old('naziv')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-text label="{{ __('Broj zvezdica') }}" name="broj_zvezdica" type="number" min="1" max="5" :value="$hotel->broj_zvezdica ?? old('broj_zvezdica')" :required="true" />
                </div>
                <div class="col-md-3">
                    <x-input-select label="{{ __('Država') }}" name="id_drzave" :items="$drzave" :value="$hotel->id_drzave ?? old('id_drzave')" :emptyOption="true" :required="true"/>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <x-input-text label="{{ __('Grad') }}" name="grad" :value="$hotel->grad ?? old('grad')" :required="true"/>
                </div>
                <div class="col-md-4">
                    <x-input-text label="{{ __('Adresa') }}" name="adresa" :value="$hotel->adresa ?? old('adresa')" :required="true"/>
                </div>
                <div class="col-md-4">
                    <x-input-text label="{{ __('Telefon') }}" name="telefon" :value="$hotel->telefon ?? old('telefon')" :required="true" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <x-input-text label="{{ __('Email') }}" name="email" type="email" :value="$hotel->email ?? old('email')" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <x-input-textarea label="{{ __('Opis') }}" name="opis" :value="$hotel->opis ?? old('opis')" rows="4" />
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn button-primary">
                    <i class="fa fa-save"></i> {{ __('Sačuvaj') }}
                </button>
                <a href="{{ route('hoteli.index') }}" class="btn btn-secondary">
                    <i class="fa fa-times"></i> {{ __('Otkaži') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection