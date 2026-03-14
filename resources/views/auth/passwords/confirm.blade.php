@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="logo-placeholder mb-3">
                <!-- Ovde može logo -->
            </div>
            <h3>{{ __('Potvrdi lozinku') }}</h3>
            <p class="text-muted">
                {{ __('Molimo vas da potvrdite svoju lozinku pre nego što nastavite.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Lozinka') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">

                @error('password')
                    <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-primary">
                {{ __('Potvrdi lozinku') }}
            </button>

            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="btn btn-link">
                        {{ __('Zaboravili ste lozinku?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
