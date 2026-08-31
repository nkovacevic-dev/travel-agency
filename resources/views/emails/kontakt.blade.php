<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova kontakt poruka</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #4a5568;
        }

        .wrapper {
            width: 100%;
            padding: 40px 0;
            background-color: #f0f4f8;
        }

        .card {
            max-width: 560px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background-color: #1a5f7a;
            padding: 28px 40px;
            text-align: center;
        }

        .header a {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .body {
            padding: 36px 40px;
        }

        h1 {
            font-size: 20px;
            color: #1a5f7a;
            margin: 0 0 16px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 4px;
        }

        .field-value {
            font-size: 15px;
            color: #2d3748;
            line-height: 1.6;
        }

        .poruka-box {
            background-color: #f7fafc;
            border-left: 4px solid #1a5f7a;
            padding: 16px;
            border-radius: 0 4px 4px 0;
            font-size: 15px;
            line-height: 1.7;
            color: #2d3748;
            white-space: pre-wrap;
        }

        .divider {
            border: none;
            border-top: 1px solid #e8e8e8;
            margin: 28px 0;
        }

        .footer {
            background-color: #f7fafc;
            padding: 18px 40px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>
            </div>
            <div class="body">
                <h1>Nova poruka sa kontakt forme</h1>

                <div class="field">
                    <div class="field-label">Ime i prezime</div>
                    <div class="field-value">{{ $imePosiljaoca }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Email</div>
                    <div class="field-value">{{ $emailPosiljaoca }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Telefon</div>
                    <div class="field-value">{{ $telefon ?: '—' }}</div>
                </div>

                <hr class="divider">

                <div class="field">
                    <div class="field-label">Poruka</div>
                    <div class="poruka-box">{{ $poruka }}</div>
                </div>
            </div>
            <div class="footer">
                Poruka je automatski generisana sa sajta {{ config('app.url') }}
            </div>
        </div>
    </div>
</body>

</html>