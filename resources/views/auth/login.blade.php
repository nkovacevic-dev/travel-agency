@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="login-card">
        <div class="mb-4">
            <div class="logo-placeholder">
                <img src="/images/logo.png" alt="Logo" class="logo">
            </div>
            <h3>{{ __('Prijavi se') }}</h3>
            <p class="text-muted">
                {{ __('Ova aplikacija je namenjena isključivo zaposlenima naše agencije. 
    Molimo Vas da se prijavite svojim korisničkim nalogom kako biste pristupili sistemu.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Elektronska pošta') }}</label>
                <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', !empty($user)?($user->email ?? $user->name):'') }}" autocomplete="email" autofocus>
                @error('email')
                <small class="invalid-feedback d-block">{{$message}}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Šifra') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                @error('password')
                <small class="invalid-feedback d-block">{{$message}}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input id="checkbox1" class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="checkbox1" class="form-check-label text-muted mb-0">
                        {{ __('Zapamti me!') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Zaboravili ste lozinku?') }}
                </a>
                @endif
            </div>

            <button class="w-100 btn btn-primary" type="submit">
                {{ __('Prijavi se') }}
            </button>
        </form>

        <div class="text-center mt-4">
            <h6 class="text-muted">{{ __('Nemate nalog?') }}</h6>
            <a href="{{ route('register') }}" class="w-100 btn btn-outline-secondary">
                {{ __('Registruj se!') }}
            </a>
        </div>
    </div>
</div>
@endsection