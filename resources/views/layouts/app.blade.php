<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Cagnotte') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #080808;
            color: #e0e0e0;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Navbar ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            background: rgba(8,8,8,.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid #1a1a1a;
            box-shadow: 0 1px 0 rgba(255,255,255,.03), 0 4px 24px rgba(0,0,0,.4);
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        /* ── Logo ── */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: .65rem;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nav-logo-icon {
            width: 32px; height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #dc2626, #f97316);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(220,38,38,.35);
            flex-shrink: 0;
        }
        .nav-logo-text {
            font-family: 'Syne', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: #f0f0f0;
            letter-spacing: -.01em;
            line-height: 1;
        }
        .nav-logo-text span {
            background: linear-gradient(90deg, #f97316, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ── Nav links ── */
        .nav-links {
            display: flex;
            align-items: center;
            gap: .25rem;
            flex: 1;
            justify-content: center;
        }
        .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem .75rem;
            border-radius: 8px;
            font-size: .8375rem;
            font-weight: 500;
            color: #666;
            text-decoration: none;
            transition: color .2s, background .2s;
            white-space: nowrap;
        }
        .nav-link:hover {
            color: #d0d0d0;
            background: rgba(255,255,255,.04);
        }
        .nav-link.active {
            color: #f0f0f0;
            background: rgba(255,255,255,.06);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 50%;
            transform: translateX(-50%);
            width: 20px; height: 2px;
            border-radius: 2px;
            background: linear-gradient(90deg, #dc2626, #f97316);
        }

        /* CTA nav link */
        .nav-link-cta {
            display: flex;
            align-items: center;
            gap: .4rem;
            padding: .42rem .85rem;
            border-radius: 8px;
            font-size: .8375rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(135deg, #dc2626, #f97316);
            box-shadow: 0 2px 12px rgba(220,38,38,.28);
            transition: filter .2s, transform .15s, box-shadow .2s;
            white-space: nowrap;
        }
        .nav-link-cta:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            box-shadow: 0 4px 18px rgba(220,38,38,.4);
        }
        .nav-link-cta:active { transform: translateY(0); }

        /* Badge pending */
        .nav-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            padding: .1rem .4rem;
            border-radius: 20px;
            background: rgba(249,115,22,.15);
            color: #f97316;
            border: 1px solid rgba(249,115,22,.25);
            line-height: 1.4;
        }

        /* ── Right side ── */
        .nav-right {
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-shrink: 0;
        }

        /* User chip */
        .user-chip {
            display: flex;
            align-items: center;
            gap: .55rem;
            padding: .35rem .7rem .35rem .45rem;
            border-radius: 20px;
            background: #111;
            border: 1px solid #1e1e1e;
        }
        .user-avatar {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(220,38,38,.3), rgba(249,115,22,.3));
            border: 1px solid rgba(249,115,22,.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #f97316;
            flex-shrink: 0;
            font-family: 'Syne', sans-serif;
        }
        .user-name {
            font-size: .8rem;
            font-weight: 500;
            color: #888;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Role pill */
        .role-pill {
            display: none;
            font-size: 10px;
            font-weight: 600;
            padding: .15rem .5rem;
            border-radius: 20px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        .role-pill-donateur {
            background: rgba(249,115,22,.1);
            color: #f97316;
            border: 1px solid rgba(249,115,22,.2);
        }
        .role-pill-organisateur {
            background: rgba(220,38,38,.1);
            color: #dc2626;
            border: 1px solid rgba(220,38,38,.2);
        }
        .role-pill-admin {
            background: rgba(255,255,255,.06);
            color: #aaa;
            border: 1px solid #2a2a2a;
        }

        /* Logout btn */
        .btn-logout {
            display: flex;
            align-items: center;
            gap: .4rem;
            padding: .42rem .7rem;
            border-radius: 8px;
            border: 1px solid #1e1e1e;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            transition: color .2s, border-color .2s, background .2s;
        }
        .btn-logout:hover {
            color: #dc2626;
            border-color: rgba(220,38,38,.3);
            background: rgba(220,38,38,.06);
        }

        /* ── Separator ── */
        .nav-sep {
            width: 1px;
            height: 18px;
            background: #1e1e1e;
            flex-shrink: 0;
        }

        /* ── Mobile burger ── */
        .burger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid #1e1e1e;
            background: transparent;
            cursor: pointer;
            padding: 0 9px;
            transition: background .2s, border-color .2s;
        }
        .burger:hover { background: rgba(255,255,255,.04); border-color: #2a2a2a; }
        .burger span {
            display: block;
            height: 1.5px;
            border-radius: 2px;
            background: #888;
            transition: transform .25s, opacity .2s, background .2s;
        }
        .burger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); background: #f97316; }
        .burger.open span:nth-child(2) { opacity: 0; }
        .burger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); background: #f97316; }

        /* ── Mobile menu ── */
        .mobile-menu {
            display: none;
            flex-direction: column;
            background: #0a0a0a;
            border-top: 1px solid #151515;
            padding: .75rem 1.25rem 1.25rem;
            gap: .2rem;
            animation: slideDown .25s cubic-bezier(.22,1,.36,1);
        }
        .mobile-menu.open { display: flex; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .mobile-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .65rem .75rem;
            border-radius: 9px;
            font-size: .875rem;
            font-weight: 500;
            color: #666;
            text-decoration: none;
            transition: color .2s, background .2s;
        }
        .mobile-link:hover { color: #d0d0d0; background: rgba(255,255,255,.04); }
        .mobile-link.active { color: #f0f0f0; background: rgba(255,255,255,.06); }
        .mobile-link.active .mobile-link-dot { background: #f97316; }

        .mobile-link-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #2e2e2e;
            flex-shrink: 0;
            transition: background .2s;
        }

        .mobile-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin-top: .5rem;
            padding: .75rem;
            border-radius: 10px;
            background: linear-gradient(135deg, #dc2626, #f97316);
            color: #fff;
            font-weight: 600;
            font-size: .875rem;
            text-decoration: none;
            box-shadow: 0 3px 14px rgba(220,38,38,.3);
        }

        .mobile-sep {
            height: 1px;
            background: #151515;
            margin: .5rem 0;
        }

        .mobile-user-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem .75rem;
            margin-bottom: .25rem;
        }
        .mobile-user-info { display: flex; align-items: center; gap: .55rem; }
        .mobile-user-name { font-size: .875rem; font-weight: 500; color: #888; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .nav-links { display: none; }
            .nav-right  { display: none; }
            .burger     { display: flex; }
        }

        /* ── Main content ── */
        .main-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }
    </style>
</head>

<body>

{{-- ════════════════════ NAVBAR ════════════════════ --}}
<nav class="navbar" role="navigation" aria-label="Navigation principale">
    <div class="navbar-inner">

        {{-- Logo --}}
        <a href="/" class="nav-logo" aria-label="Accueil">
            <div class="nav-logo-icon">
                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <span class="nav-logo-text">Cagnotte<span>+</span></span>
        </a>

        {{-- ── Desktop nav links ── --}}
        <div class="nav-links">
            @php
                $isActive = fn($route) => request()->routeIs($route) ? 'active' : '';
            @endphp

            {{-- DONATEUR --}}
            @if(auth()->user()->isDonateur())
                <a href="{{ route('donateur.feed') }}"
                   class="nav-link {{ $isActive('donateur.feed') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                    Cagnottes
                </a>
                <a href="{{ route('donateur.historique') }}"
                   class="nav-link {{ $isActive('donateur.historique') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Historique
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="nav-link {{ $isActive('profile.*') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    Profil
                </a>
            @endif

            {{-- ORGANISATEUR --}}
            @if(auth()->user()->isOrganisateur())
                <a href="{{ route('organisateur.dashboard') }}"
                   class="nav-link {{ $isActive('organisateur.dashboard') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-12m0 0l-3 3m3-3 3 3m3-9h.008v.008H12V10.5zm0 3h.008v.008H12v-.008z"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('organisateur.cagnottes') }}"
                   class="nav-link {{ $isActive('organisateur.cagnottes') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    Mes cagnottes
                </a>
                <a href="{{ route('organisateur.historique') }}"
                   class="nav-link {{ $isActive('organisateur.historique') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Historique
                </a>
                <div class="nav-sep"></div>
                @if(auth()->user()->status === 'active')
                    <a href="{{ route('organisateur.cagnottes.create') }}"
                       class="nav-link-cta {{ $isActive('organisateur.cagnottes.create') }}">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Créer une cagnotte
                    </a>
                @else
                    <a href="{{ route('organisateur.dashboard') }}"
                       class="nav-link {{ $isActive('organisateur.dashboard') }}">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        Déposer document
                        <span class="nav-badge">En attente</span>
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                   class="nav-link {{ $isActive('profile.*') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    Profil
                </a>
            @endif

            {{-- ADMIN --}}
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ $isActive('admin.dashboard') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-12m0 0l-3 3m3-3 3 3"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.validation.organisateur') }}"
                   class="nav-link {{ $isActive('admin.validation.organisateur') }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Validation
                </a>
            @endif
        </div>

        {{-- ── Desktop right ── --}}
        <div class="nav-right">
            {{-- User chip --}}
            <div class="user-chip">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout" aria-label="Se déconnecter">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>

        {{-- ── Burger mobile ── --}}
        <button class="burger" id="burger" aria-label="Menu" aria-expanded="false" aria-controls="mobile-menu">
            <span></span><span></span><span></span>
        </button>

    </div>{{-- /navbar-inner --}}

    {{-- ════ MOBILE MENU ════ --}}
    <div class="mobile-menu" id="mobile-menu" role="menu">

        {{-- User row --}}
        <div class="mobile-user-row">
            <div class="mobile-user-info">
                <div class="user-avatar" style="width:30px;height:30px;font-size:12px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="mobile-user-name">{{ auth()->user()->name }}</span>
            </div>
            @if(auth()->user()->isDonateur())
                <span class="role-pill role-pill-donateur" style="display:inline-flex;">Donateur</span>
            @elseif(auth()->user()->isOrganisateur())
                <span class="role-pill role-pill-organisateur" style="display:inline-flex;">Organisateur</span>
            @elseif(auth()->user()->isAdmin())
                <span class="role-pill role-pill-admin" style="display:inline-flex;">Admin</span>
            @endif
        </div>

        <div class="mobile-sep"></div>

        {{-- DONATEUR mobile --}}
        @if(auth()->user()->isDonateur())
            <a href="{{ route('donateur.feed') }}"
               class="mobile-link {{ request()->routeIs('donateur.feed') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Cagnottes
            </a>
            <a href="{{ route('donateur.historique') }}"
               class="mobile-link {{ request()->routeIs('donateur.historique') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Historique
            </a>
            <a href="{{ route('profile.edit') }}"
               class="mobile-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Profil
            </a>
        @endif

        {{-- ORGANISATEUR mobile --}}
        @if(auth()->user()->isOrganisateur())
            <a href="{{ route('organisateur.dashboard') }}"
               class="mobile-link {{ request()->routeIs('organisateur.dashboard') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Dashboard
            </a>
            <a href="{{ route('organisateur.cagnottes') }}"
               class="mobile-link {{ request()->routeIs('organisateur.cagnottes') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Mes cagnottes
            </a>
            <a href="{{ route('organisateur.historique') }}"
               class="mobile-link {{ request()->routeIs('organisateur.historique') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Historique
            </a>
            @if(auth()->user()->status === 'active')
                <a href="{{ route('organisateur.cagnottes.create') }}" class="mobile-cta" role="menuitem">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Créer une cagnotte
                </a>
            @else
                <a href="{{ route('organisateur.dashboard') }}"
                   class="mobile-link {{ request()->routeIs('organisateur.dashboard') ? 'active' : '' }}" role="menuitem">
                    <div class="mobile-link-dot"></div> Déposer document
                    <span class="nav-badge" style="margin-left:auto;">En attente</span>
                </a>
            @endif
            <a href="{{ route('profile.edit') }}"
               class="mobile-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Profil
            </a>
        @endif

        {{-- ADMIN mobile --}}
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
               class="mobile-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Dashboard
            </a>
            <a href="{{ route('admin.validation.organisateur') }}"
               class="mobile-link {{ request()->routeIs('admin.validation.organisateur') ? 'active' : '' }}" role="menuitem">
                <div class="mobile-link-dot"></div> Validation
            </a>
        @endif

        <div class="mobile-sep"></div>

        {{-- Logout mobile --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mobile-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;color:#dc2626;" role="menuitem">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                </svg>
                Déconnexion
            </button>
        </form>

    </div>{{-- /mobile-menu --}}

</nav>

{{-- ════════════════════ MAIN ════════════════════ --}}
<main class="main-content">
    {{ $slot }}
</main>

<script>
    const burger      = document.getElementById('burger');
    const mobileMenu  = document.getElementById('mobile-menu');

    burger.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.toggle('open');
        burger.classList.toggle('open', isOpen);
        burger.setAttribute('aria-expanded', isOpen);
    });

    // Fermer au clic extérieur
    document.addEventListener('click', (e) => {
        if (!burger.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.remove('open');
            burger.classList.remove('open');
            burger.setAttribute('aria-expanded', 'false');
        }
    });
</script>

</body>
</html>