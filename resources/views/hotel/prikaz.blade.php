@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Prikaz hotela</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <x-input-text label="{{ __('Naziv') }}" name="naziv" :value="$hotel->naziv" :readonly="true" />
            </div>
            <div class="col-md-3">
                <x-input-text label="{{ __('Broj zvezdica') }}" name="broj_zvezdica" type="number" :value="$hotel->broj_zvezdica" :readonly="true" />
            </div>
            <div class="col-md-3">
                <x-input-select label="{{ __('Država') }}" name="id_drzave" :items="$drzave" :value="$hotel->id_drzave" :readonly="true"/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <x-input-text label="{{ __('Grad') }}" name="grad" :value="$hotel->grad" :readonly="true"/>
            </div>
            <div class="col-md-4">
                <x-input-text label="{{ __('Adresa') }}" name="adresa" :value="$hotel->adresa" :readonly="true"/>
            </div>
            <div class="col-md-4">
                <x-input-text label="{{ __('Telefon') }}" name="telefon" :value="$hotel->telefon" :readonly="true" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-input-text label="{{ __('Email') }}" name="email" type="email" :value="$hotel->email" :readonly="true" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <x-input-textarea label="{{ __('Opis') }}" name="opis" :value="$hotel->opis" rows="4" :readonly="true" />
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('hoteli.edit', $hotel->id) }}" class="btn button-primary">
                {{ __('Izmeni') }}
            </a>
            <a href="{{ route('hoteli.index') }}" class="btn button-secondary">
                {{ __('Nazad') }}
            </a>
        </div>
    </div>
</div>
@endsection
