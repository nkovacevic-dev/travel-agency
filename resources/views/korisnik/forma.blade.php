@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ isset($korisnik->id) ? 'Izmena korisnika' : 'Novi korisnik' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($korisnik->id) ? route('korisnici.update', $korisnik->id) : route('korisnici.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($korisnik->id))
                @method('PUT')
            @endif
            <input type="hidden" name="_redirect" value="{{ $redirectTo ?? 'korisnici.index' }}">
            
            <div class="row">
                <div class="col-md-6">
                    <x-input-text label="{{ __('Ime i prezime') }}" name="name" :value="$korisnik->name ?? old('name')" :required="true" />
                </div>
                <div class="col-md-6">
                    <x-input-text label="{{ __('Email') }}" name="email" :value="$korisnik->email ?? old('email')" :required="true" />
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            {{ __('Šifra') }}
                            @if(isset($korisnik->id))
                                <span class="text-muted fw-normal">(ostavite prazno ako ne menjate)</span>
                            @endif
                        </label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" {{ !isset($korisnik->id) ? 'required' : '' }}
                               autocomplete="new-password">
                        @error('password')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Potvrdi šifru') }}</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" {{ !isset($korisnik->id) ? 'required' : '' }}
                               autocomplete="new-password">
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn button-primary">
                     {{ __('Sačuvaj') }}
                </button>
                <a href="{{ route('korisnici.index') }}" class="btn button-secondary">
                     {{ __('Nazad') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection