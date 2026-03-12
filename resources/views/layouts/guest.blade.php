<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: #080808;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Fond atmosphérique fixe ── */
        .bg-scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }
        .bg-orb-red {
            position: absolute;
            top: -15%;
            left: -10%;
            width: 55%;
            height: 65%;
            background: radial-gradient(ellipse, rgba(220,38,38,.08) 0%, transparent 65%);
        }
        .bg-orb-orange {
            position: absolute;
            bottom: -10%;
            right: -5%;
            width: 50%;
            height: 55%;
            background: radial-gradient(ellipse, rgba(249,115,22,.06) 0%, transparent 65%);
        }
        .bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.016) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.016) 1px, transparent 1px);
            background-size: 52px 52px;
        }

        /* ── Page wrapper ── */
        .page-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.25rem;
        }

        /* ── Logo area ── */
        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 2rem;
        }
        .logo-ring {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(220,38,38,.18), rgba(249,115,22,.12));
            border: 1px solid rgba(249,115,22,.25);
            transition: box-shadow .3s ease, border-color .3s ease, transform .2s ease;
            text-decoration: none;
        }
        .logo-ring:hover {
            box-shadow: 0 0 28px rgba(249,115,22,.22);
            border-color: rgba(249,115,22,.5);
            transform: translateY(-2px);
        }
        .logo-ring svg,
        .logo-ring img {
            width: 28px;
            height: 28px;
        }
        .logo-name {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #383838;
        }

        /* ── Auth card ── */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #0d0d0d;
            border: 1px solid #1c1c1c;
            border-radius: 22px;
            padding: 2.25rem 2.25rem 1.75rem;
            box-shadow:
                0 0 0 1px rgba(255,255,255,.025),
                0 32px 72px rgba(0,0,0,.65),
                0 8px 24px rgba(0,0,0,.45);
            animation: cardIn .5s cubic-bezier(.22,1,.36,1) both;
        }

        /* ── Card footer ── */
        .card-sep {
            height: 1px;
            background: linear-gradient(90deg, transparent, #1c1c1c 25%, #1c1c1c 75%, transparent);
            margin: 1.75rem -2.25rem 0;
        }
        .card-footer-note {
            margin-top: 1rem;
            text-align: center;
            font-size: 11px;
            color: #282828;
        }

        /* ── Page footer ── */
        .page-footer {
            margin-top: 1.75rem;
            font-size: 11px;
            color: #282828;
        }

        /* ── Animation ── */
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px) scale(.985); }
            to   { opacity: 1; transform: translateY(0)    scale(1); }
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .auth-card {
                padding: 1.75rem 1.5rem 1.5rem;
                border-radius: 18px;
            }
            .card-sep {
                margin: 1.5rem -1.5rem 0;
            }
        }
    </style>
</head>

<body>
    {{-- Décor de fond --}}
    <div class="bg-scene">
        <div class="bg-grid"></div>
        <div class="bg-orb-red"></div>
        <div class="bg-orb-orange"></div>
    </div>

    {{-- Page --}}
    <div class="page-wrapper">

        {{-- Logo --}}
        <div class="logo-wrap">
            <a href="/" class="logo-ring" aria-label="Accueil">
                <x-application-logo style="width:28px;height:28px;fill:#f97316;" />
            </a>
            <span class="logo-name">{{ config('app.name', 'Laravel') }}</span>
        </div>

        {{-- Card --}}
        <div class="auth-card">
            {{ $slot }}
            <div class="card-sep"></div>
            <p class="card-footer-note">
                🔒 Connexion sécurisée &mdash; vos données sont protégées
            </p>
        </div>

        {{-- Footer --}}
        <p class="page-footer">
            &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; Tous droits réservés
        </p>

    </div>
</body>
</html>