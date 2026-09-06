@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="mb-4">
             <div class="logo-placeholder">
                <img src="/images/logo.png" alt="Logo" class="logo-auth">
            </div>
            <h3>{{ __('Reset lozinke') }}</h3>
            <p class="text-muted">
                {{ __('Unesite svoju novu lozinku kako biste resetovali postojeću.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label">{{ __('Email adresa') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ $email ?? old('email') }}"
                       autocomplete="email" autofocus>
                @error('email')
                <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Nova lozinka') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" autocomplete="new-password">
                @error('password')
                <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Potvrdi lozinku') }}</label>
                <input id="password-confirm" type="password"
                       class="form-control"
                       name="password_confirmation" autocomplete="new-password">
            </div>

            <button class="w-100 btn button-primary" type="submit">
                {{ __('Reset lozinke') }}
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-muted">
                {{ __('Nazad na prijavu') }}
            </a>
        </div>
    </div>
</div>
@endsection
