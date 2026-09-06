@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="mb-4">
            <div class="logo-placeholder">
                <a href="{{ url('/login') }}">
                    <img src="/images/logo.png" alt="Logo" class="logo-auth">
                </a>
            </div>
            <h3>{{ __('Registruj se') }}</h3>
            <p class="text-muted">
                {{ __('Popunite formu ispod da biste kreirali svoj službeni nalog.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Ime i prezime') }}</label>
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                @error('name')
                    <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email adresa') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" autocomplete="email">
                @error('email')
                    <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Šifra') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" autocomplete="new-password">
                @error('password')
                    <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">{{ __('Potvrdi šifru') }}</label>
                <input id="password-confirm" type="password"
                       class="form-control"
                       name="password_confirmation" autocomplete="new-password">
            </div>

            <button type="submit" class="w-100 btn btn-primary">
                {{ __('Registruj se') }}
            </button>
        </form>

        <!-- <div class="text-center mt-4">
            <h6 class="text-muted">{{ __('Već imate nalog?') }}</h6>
            <a href="{{ route('login') }}" class="w-100 btn button-secondary">
                {{ __('Prijavi se!') }}
            </a>
        </div> -->
    </div>
</div>
@endsection
