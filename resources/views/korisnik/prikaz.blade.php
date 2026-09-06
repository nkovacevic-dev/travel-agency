@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Prikaz korisnika</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <x-input-text label="{{ __('Ime i prezime') }}" name="name" :value="$korisnik->name" :readonly="true" />
            </div>
            <div class="col-md-6">
                <x-input-text label="{{ __('Email') }}" name="email" type="email" :value="$korisnik->email" :readonly="true" />
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('korisnici.edit', $korisnik->id) }}" class="btn button-primary">
                {{ __('Izmeni') }}
            </a>
            <a href="{{ route('korisnici.index') }}" class="btn button-secondary">
                {{ __('Nazad') }}
            </a>
        </div>
    </div>
</div>
@endsection
