<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Reset lozinke') }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f0f4f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #4a5568; }
        .wrapper { width: 100%; padding: 40px 0; background-color: #f0f4f8; }
        .card { max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; }
        .header { background-color: #1a5f7a; padding: 28px 40px; text-align: center; }
        .header a { color: #ffffff; font-size: 22px; font-weight: 700; text-decoration: none; letter-spacing: 0.5px; }
        .body { padding: 36px 40px; }
        h1 { font-size: 20px; color: #1a5f7a; margin: 0 0 16px; }
        p { font-size: 15px; line-height: 1.6; margin: 0 0 20px; }
        .btn-wrap { text-align: center; margin: 32px 0; }
        .btn { display: inline-block; background-color: #1a5f7a; color: #ffffff !important; text-decoration: none; padding: 13px 32px; border-radius: 5px; font-size: 15px; font-weight: 600; }
        .expire { font-size: 13px; color: #718096; }
        .divider { border: none; border-top: 1px solid #e8e8e8; margin: 28px 0; }
        .fallback { font-size: 13px; color: #718096; line-height: 1.6; }
        .fallback a { color: #1a5f7a; word-break: break-all; }
        .footer { background-color: #f7fafc; padding: 18px 40px; text-align: center; font-size: 12px; color: #a0aec0; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>
        </div>
        <div class="body">
            <h1>{{ __('Zdravo!') }}</h1>
            <p>{{ __('Primili smo zahtev za resetovanje lozinke za Vaš nalog. Kliknite na dugme ispod da biste postavili novu lozinku.') }}</p>

            <div class="btn-wrap">
                <a href="{{ $resetUrl }}" class="btn">{{ __('Resetuj lozinku') }}</a>
            </div>

            <p class="expire">{{ __('Ovaj link je važeći 60 minuta. Ukoliko niste tražili reset lozinke, ignorišite ovaj email.') }}</p>

            <hr class="divider">

            <p class="fallback">
                {{ __('Ukoliko dugme ne radi, kopirajte i nalepite sledeći link u pretraživač:') }}<br>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('Sva prava zadržana.') }}
        </div>
    </div>
</div>
</body>
</html>
