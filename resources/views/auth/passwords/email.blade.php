@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="mb-4">
            <div class="logo-placeholder">
                <img src="/images/logo.png" alt="Logo" class="logo-auth">
            </div>
            <h3>{{ __('Resetuj lozinku') }}</h3>
            <p class="text-muted">
                {{ __('Unesite svoju email adresu i poslaćemo vam link za reset lozinke.') }}
            </p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email adresa') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-primary">
                {{ __('Pošalji link za reset lozinke') }}
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="w-100 btn button-secondary">
                {{ __('Nazad na prijavu') }}
            </a>
        </div>
    </div>
</div>
@endsection
