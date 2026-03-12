<x-app-layout>

<style>
    *, *::before, *::after { box-sizing: border-box; }
    .page { font-family: 'DM Sans', sans-serif; }
    .dash-title { font-family: 'Syne', sans-serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fu   { animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .45s .08s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .45s .16s cubic-bezier(.22,1,.36,1) both; }
    .fu-4 { animation: fadeUp .45s .24s cubic-bezier(.22,1,.36,1) both; }

    /* ── Layout ── */
    .show-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 900px) {
        .show-grid { grid-template-columns: 1fr; }
        .sidebar { order: -1; }
    }

    /* ── Hero image ── */
    .hero-img-wrap {
        position: relative; border-radius: 16px;
        overflow: hidden; background: #0a0a0a;
        border: 1px solid #1a1a1a;
        aspect-ratio: 16/7;
    }
    .hero-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        display: block;
    }
    .hero-no-img {
        aspect-ratio: 16/7; border-radius: 16px;
        background: #0a0a0a; border: 1px solid #1a1a1a;
        display: flex; align-items: center; justify-content: center;
    }

    /* ── Main card ── */
    .main-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px; overflow: hidden;
    }
    .main-body { padding: 1.75rem; }

    /* ── Sidebar card ── */
    .sidebar-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px; overflow: hidden;
        position: sticky; top: 80px;
    }
    .sidebar-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.1rem; }

    /* ── Organisateur chip ── */
    .org-chip {
        display: inline-flex; align-items: center; gap: .6rem;
        padding: .45rem .85rem .45rem .5rem;
        border-radius: 30px; background: #111;
        border: 1px solid #1a1a1a;
    }
    .org-avatar {
        width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, rgba(220,38,38,.25), rgba(249,115,22,.2));
        border: 1px solid rgba(249,115,22,.25);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 800; color: #f97316;
        font-family: 'Syne', sans-serif;
    }
    .org-name { font-size: .8125rem; font-weight: 600; color: #888; }

    /* ── Description ── */
    .description-body {
        font-size: .875rem; color: #666; line-height: 1.75;
    }
    .description-body p { margin: 0 0 .75rem; }
    .description-body p:last-child { margin: 0; }

    /* ── Progress block ── */
    .prog-track {
        height: 6px; border-radius: 6px;
        background: #141414; overflow: hidden;
    }
    .prog-fill {
        height: 100%; border-radius: 6px;
        background: linear-gradient(90deg, #dc2626, #f97316);
        transition: width .6s ease;
    }

    /* ── Stat row ── */
    .stat-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: .65rem;
    }
    .stat-mini {
        background: #111; border: 1px solid #141414;
        border-radius: 11px; padding: .75rem .9rem;
    }

    /* ── CTA buttons ── */
    .btn-don {
        display: flex; align-items: center; justify-content: center; gap: .5rem;
        width: 100%; padding: .9rem; border-radius: 12px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .9rem; font-weight: 700; cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(220,38,38,.32);
        transition: filter .2s, transform .15s, box-shadow .2s;
    }
    .btn-don:hover { filter: brightness(1.08); transform: translateY(-1px); box-shadow: 0 6px 28px rgba(220,38,38,.42); }
    .btn-don:active { transform: translateY(0); }
    .btn-don .arrow { transition: transform .2s; }
    .btn-don:hover .arrow { transform: translateX(4px); }

    .btn-login {
        display: flex; align-items: center; justify-content: center; gap: .5rem;
        width: 100%; padding: .85rem; border-radius: 12px;
        border: 1px solid #2a2a2a; background: #111;
        color: #888; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 600; text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
    }
    .btn-login:hover { color: #d0d0d0; border-color: #3a3a3a; background: #161616; }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* ── Section divider ── */
    .divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #1a1a1a 30%, #1a1a1a 70%, transparent);
        margin: 1.25rem 0;
    }

    /* ── Badge ── */
    .badge-active {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 600;
        padding: .2rem .65rem; border-radius: 20px;
        background: rgba(34,197,94,.1); color: #4ade80;
        border: 1px solid rgba(34,197,94,.2);
    }
    .badge-active .dot {
        width: 5px; height: 5px; border-radius: 50%;
        background: #4ade80; box-shadow: 0 0 4px #4ade80;
    }

    /* ── Secure note ── */
    .secure-note {
        display: flex; align-items: center; justify-content: center;
        gap: .4rem; font-size: .72rem; color: #2e2e2e;
    }

    /* ── Video embed ── */
    .video-wrap {
        position: relative; padding-bottom: 56.25%; height: 0;
        overflow: hidden; border-radius: 12px; border: 1px solid #1a1a1a;
    }
    .video-wrap iframe {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;
    }

    /* ── Back link ── */
    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .8rem; font-weight: 500; color: #444;
        text-decoration: none; transition: color .2s;
    }
    .back-link:hover { color: #f97316; }

    /* ── Goal achieved banner ── */
    .goal-banner {
        display: flex; align-items: center; gap: .65rem;
        padding: .85rem 1rem; border-radius: 11px;
        background: rgba(34,197,94,.07); border: 1px solid rgba(34,197,94,.2);
    }

    @media (max-width: 640px) {
        .main-body { padding: 1.25rem; }
        .sidebar-body { padding: 1.1rem; }
    }
</style>

<div class="page" style="max-width:1100px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.25rem;">

    {{-- ── Back + breadcrumb ── --}}
    <div class="fu">
        <a href="{{ route('donateur.feed') }}" class="back-link">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Retour aux cagnottes
        </a>
    </div>

    {{-- ── Main grid ── --}}
    <div class="show-grid">

        {{-- ════ COLONNE PRINCIPALE ════ --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Hero image --}}
            @if($cagnotte->image_path)
                <div class="hero-img-wrap fu">
                    <img src="{{ asset('storage/'.$cagnotte->image_path) }}"
                         alt="{{ $cagnotte->title }}" loading="eager" />
                </div>
            @else
                <div class="hero-no-img fu">
                    <svg width="48" height="48" fill="none" stroke="#1e1e1e" stroke-width="1.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </div>
            @endif

            {{-- Main content card --}}
            <div class="main-card fu-2">
                <div class="main-body">

                    {{-- Top row: badge + organisateur --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem;">
                        <span class="badge-active">
                            <div class="dot"></div> Collecte active
                        </span>
                        <div class="org-chip">
                            <div class="org-avatar">
                                {{ strtoupper(substr($cagnotte->organisateur->name, 0, 1)) }}
                            </div>
                            <span class="org-name">{{ $cagnotte->organisateur->name }}</span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0 0 1.25rem;line-height:1.25;letter-spacing:-.02em;">
                        {{ $cagnotte->title }}
                    </h1>

                    <div class="divider"></div>

                    {{-- Description --}}
                    <p class="section-label" style="margin-bottom:.75rem;">À propos de cette campagne</p>
                    <div class="description-body">
                        {!! nl2br(e($cagnotte->description)) !!}
                    </div>

                    {{-- Video (if any) --}}
                    @if($cagnotte->video_url)
                        <div class="divider"></div>
                        <p class="section-label" style="margin-bottom:.75rem;">Vidéo de présentation</p>
                        @php
                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $cagnotte->video_url, $yt);
                            preg_match('/vimeo\.com\/(\d+)/', $cagnotte->video_url, $vi);
                        @endphp
                        @if(!empty($yt[1]))
                            <div class="video-wrap">
                                <iframe src="https://www.youtube.com/embed/{{ $yt[1] }}"
                                        allowfullscreen loading="lazy"></iframe>
                            </div>
                        @elseif(!empty($vi[1]))
                            <div class="video-wrap">
                                <iframe src="https://player.vimeo.com/video/{{ $vi[1] }}"
                                        allowfullscreen loading="lazy"></iframe>
                            </div>
                        @else
                            <a href="{{ $cagnotte->video_url }}" target="_blank" rel="noopener"
                               style="display:inline-flex;align-items:center;gap:.4rem;font-size:.8125rem;color:#f97316;text-decoration:none;font-weight:500;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                                Voir la vidéo de présentation
                            </a>
                        @endif
                    @endif

                </div>
            </div>

        </div>

        {{-- ════ SIDEBAR ════ --}}
        <div class="sidebar">
            <div class="sidebar-card fu-3">
                <div class="sidebar-body">

                    {{-- Montant collecté --}}
                    <div>
                        <p class="section-label" style="margin-bottom:.5rem;">Collecte en cours</p>
                        <p class="dash-title" style="font-size:1.75rem;font-weight:800;color:#4ade80;margin:0 0 .2rem;line-height:1;">
                            {{ number_format($montantCollecte, 0, ',', ' ') }}
                            <span style="font-size:.95rem;font-weight:600;color:#2d6a3f;">FCFA</span>
                        </p>
                        <p style="font-size:.8rem;color:#444;margin:0 0 .9rem;">
                            sur
                            <span style="color:#fb923c;font-weight:600;">
                                {{ number_format($objectif, 0, ',', ' ') }} FCFA
                            </span>
                            d'objectif
                        </p>

                        {{-- Progress --}}
                        <div>
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.45rem;">
                                <span style="font-size:.75rem;color:#555;font-weight:500;">Progression</span>
                                <span style="font-size:.875rem;font-weight:800;
                                      color:{{ $progression >= 100 ? '#4ade80' : ($progression >= 60 ? '#fb923c' : '#888') }};">
                                    {{ min($progression, 100) }}%
                                </span>
                            </div>
                            <div class="prog-track">
                                <div class="prog-fill" style="width:{{ min($progression, 100) }}%;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Goal achieved --}}
                    @if($progression >= 100)
                        <div class="goal-banner">
                            <svg width="16" height="16" fill="none" stroke="#4ade80" stroke-width="2.2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p style="font-size:.8rem;color:#4ade80;font-weight:600;margin:0;">
                                Objectif atteint ! La collecte continue.
                            </p>
                        </div>
                    @endif

                    {{-- Stats --}}
                    <div class="stat-row">
                        <div class="stat-mini">
                            <p class="section-label" style="margin:0 0 .3rem;">Objectif</p>
                            <p style="font-size:.875rem;font-weight:700;color:#fb923c;margin:0;line-height:1.1;">
                                {{ number_format($objectif, 0, ',', ' ') }}
                                <span style="font-size:.7rem;color:#7c3d12;"> FCFA</span>
                            </p>
                        </div>
                        <div class="stat-mini">
                            <p class="section-label" style="margin:0 0 .3rem;">Restant</p>
                            @php $restant = max(0, $objectif - $montantCollecte); @endphp
                            <p style="font-size:.875rem;font-weight:700;color:#888;margin:0;line-height:1.1;">
                                {{ number_format($restant, 0, ',', ' ') }}
                                <span style="font-size:.7rem;color:#3a3a3a;"> FCFA</span>
                            </p>
                        </div>
                    </div>

                    <div style="height:1px;background:#141414;"></div>

                    {{-- CTA --}}
                    @auth
                        @if(auth()->user()->isDonateur())
                            <a href="{{ route('donateur.dons.create', $cagnotte->id) }}" class="btn-don">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                </svg>
                                <span>Faire un don</span>
                                <svg class="arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>
                        @else
                            {{-- Organisateur ou admin connecté --}}
                            <div style="padding:.75rem 1rem;border-radius:11px;background:#111;border:1px solid #1a1a1a;text-align:center;">
                                <p style="font-size:.775rem;color:#555;margin:0;line-height:1.5;">
                                    Connecté en tant qu'organisateur.<br>Seuls les donateurs peuvent effectuer un don.
                                </p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-don">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <span>Se connecter pour donner</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn-login">
                            Créer un compte gratuitement
                        </a>
                    @endauth

                    {{-- Secure note --}}
                    <div class="secure-note">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Paiement sécurisé via FedaPay
                    </div>

                    {{-- Published date --}}
                    @if($cagnotte->published_at)
                        <p style="font-size:.72rem;color:#2a2a2a;text-align:center;margin:0;">
                            Publiée le {{ \Carbon\Carbon::parse($cagnotte->published_at)->format('d/m/Y') }}
                        </p>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

</x-app-layout>