<x-app-layout>

<style>
    *, *::before, *::after { box-sizing: border-box; }
    .page { font-family: 'DM Sans', sans-serif; }
    .dash-title { font-family: 'Syne', sans-serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50%       { opacity: .35; }
    }
    .fu   { animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .4s .07s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .4s .14s cubic-bezier(.22,1,.36,1) both; }
    .fu-4 { animation: fadeUp .4s .21s cubic-bezier(.22,1,.36,1) both; }
    .fu-5 { animation: fadeUp .4s .28s cubic-bezier(.22,1,.36,1) both; }

    /* ── Alerts ── */
    .alert {
        display: flex; align-items: center; gap: .65rem;
        padding: .85rem 1.1rem; border-radius: 12px;
        font-size: .8375rem; font-weight: 500;
    }
    .alert-success { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.2); color: #4ade80; }
    .alert-error   { background: rgba(220,38,38,.08); border: 1px solid rgba(220,38,38,.2);  color: #f87171; }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* ── Hero banner ── */
    .hero-banner {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 20px; overflow: hidden; position: relative;
        padding: 2rem 2rem;
    }
    .hero-orb {
        position: absolute; border-radius: 50%;
        filter: blur(80px); pointer-events: none;
    }

    /* ── Stat cards ── */
    .stats-grid {
        display: grid; gap: 1rem;
        grid-template-columns: repeat(4, 1fr);
    }
    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 480px)  { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 14px; padding: 1.1rem 1.35rem;
        position: relative; overflow: hidden;
        transition: border-color .2s, box-shadow .2s;
    }
    .stat-card:hover { border-color: #2a2a2a; box-shadow: 0 4px 20px rgba(0,0,0,.35); }
    .stat-accent {
        position: absolute; top: 0; left: 0;
        width: 3px; height: 100%; border-radius: 3px 0 0 3px;
    }
    .stat-icon {
        width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .8rem;
    }

    /* ── Bottom grid ── */
    .bottom-grid {
        display: grid; gap: 1.25rem;
        grid-template-columns: 1fr 340px;
    }
    @media (max-width: 900px) { .bottom-grid { grid-template-columns: 1fr; } }

    /* ── Section card ── */
    .section-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px; overflow: hidden;
    }
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.35rem; border-bottom: 1px solid #111;
    }

    /* ── Finance grid ── */
    .finance-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: .75rem; padding: 1.35rem;
    }
    @media (max-width: 480px) { .finance-grid { grid-template-columns: 1fr; } }

    .fin-cell {
        background: #0a0a0a; border: 1px solid #141414;
        border-radius: 12px; padding: .9rem 1rem;
        transition: border-color .2s;
    }
    .fin-cell:hover { border-color: #1e1e1e; }

    /* ── Action buttons ── */
    .action-btn-primary {
        display: flex; align-items: center; gap: .55rem;
        padding: .85rem 1.1rem; border-radius: 12px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .8375rem; font-weight: 700; cursor: pointer;
        text-decoration: none;
        box-shadow: 0 3px 14px rgba(220,38,38,.28);
        transition: filter .2s, transform .15s;
    }
    .action-btn-primary:hover { filter: brightness(1.1); transform: translateY(-1px); }

    .action-btn-ghost {
        display: flex; align-items: center; gap: .55rem;
        padding: .85rem 1.1rem; border-radius: 12px;
        border: 1px solid #1e1e1e; background: #0a0a0a;
        color: #666; font-family: 'DM Sans', sans-serif;
        font-size: .8375rem; font-weight: 500;
        text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
    }
    .action-btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: #111; }

    /* ── Priority banner ── */
    .priority-banner {
        display: flex; align-items: flex-start; gap: .65rem;
        padding: .9rem 1rem; border-radius: 12px;
        background: rgba(251,191,36,.06); border: 1px solid rgba(251,191,36,.2);
    }
    .pulse-dot {
        width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 3px;
        background: #fbbf24;
        box-shadow: 0 0 6px #fbbf24;
        animation: pulse-dot 1.6s ease-in-out infinite;
    }

    /* ── Pending badge ── */
    .pending-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 700;
        padding: .2rem .65rem; border-radius: 20px;
        background: rgba(251,191,36,.1); color: #fbbf24;
        border: 1px solid rgba(251,191,36,.25);
    }
</style>

<div class="page" style="max-width:1200px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.5rem;">

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="alert alert-success fu">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error fu">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Hero ── --}}
    <div class="hero-banner fu">
        {{-- Orbs --}}
        <div class="hero-orb" style="width:320px;height:320px;background:rgba(220,38,38,.12);top:-100px;right:-60px;"></div>
        <div class="hero-orb" style="width:220px;height:220px;background:rgba(249,115,22,.08);bottom:-80px;left:30%;"></div>

        <div style="position:relative;display:flex;align-items:flex-start;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
            <div>
                <p class="section-label" style="margin-bottom:.5rem;">Administration</p>
                <h1 class="dash-title" style="font-size:1.65rem;font-weight:800;color:#f0f0f0;margin:0 0 .6rem;letter-spacing:-.02em;line-height:1.2;">
                    Tableau de bord
                </h1>
                <p style="font-size:.85rem;color:#555;margin:0;max-width:460px;line-height:1.6;">
                    Suivez les performances de la plateforme, les validations en attente et les revenus générés en temps réel.
                </p>
            </div>

            {{-- Pending highlight --}}
            @if($organisateursPending > 0)
                <div style="background:#0a0a0a;border:1px solid rgba(251,191,36,.25);border-radius:14px;padding:1rem 1.35rem;min-width:180px;flex-shrink:0;">
                    <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.4rem;">
                        <div class="pulse-dot"></div>
                        <p class="section-label" style="color:#7c5a00;">En attente</p>
                    </div>
                    <p class="dash-title" style="font-size:2.5rem;font-weight:800;color:#fbbf24;margin:0;line-height:1;">
                        {{ $organisateursPending }}
                    </p>
                    <p style="font-size:.75rem;color:#6b4f00;margin:.25rem 0 0;font-weight:500;">
                        dossier{{ $organisateursPending > 1 ? 's' : '' }} à valider
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- ── 4 Stat cards ── --}}
    <div class="stats-grid fu-2">

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#16a34a,#4ade80);"></div>
            <div class="stat-icon" style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.15);">
                <svg width="14" height="14" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Total dons validés</p>
            <p class="dash-title" style="font-size:1.4rem;font-weight:800;color:#4ade80;margin:0;line-height:1.1;">
                {{ number_format($totalDons, 0, ',', ' ') }}
                <span style="font-size:.75rem;color:#2d6a3f;font-weight:600;"> FCFA</span>
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#dc2626,#f97316);"></div>
            <div class="stat-icon" style="background:rgba(220,38,38,.08);border:1px solid rgba(220,38,38,.15);">
                <svg width="14" height="14" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Total commissions</p>
            <p class="dash-title" style="font-size:1.4rem;font-weight:800;color:#f87171;margin:0;line-height:1.1;">
                {{ number_format($totalCommissions, 0, ',', ' ') }}
                <span style="font-size:.75rem;color:#7f1d1d;font-weight:600;"> FCFA</span>
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#f97316,#fbbf24);"></div>
            <div class="stat-icon" style="background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.15);">
                <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Cagnottes actives</p>
            <p class="dash-title" style="font-size:1.4rem;font-weight:800;color:#fb923c;margin:0;line-height:1.1;">
                {{ number_format($totalCagnottes, 0, ',', ' ') }}
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#6366f1,#818cf8);"></div>
            <div class="stat-icon" style="background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.15);">
                <svg width="14" height="14" fill="none" stroke="#818cf8" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Utilisateurs inscrits</p>
            <p class="dash-title" style="font-size:1.4rem;font-weight:800;color:#818cf8;margin:0;line-height:1.1;">
                {{ number_format($totalUtilisateurs, 0, ',', ' ') }}
            </p>
        </div>

    </div>

    {{-- ── Bottom grid: Finance + Actions ── --}}
    <div class="bottom-grid fu-3">

        {{-- Finance summary --}}
        <div class="section-card">
            <div class="section-header">
                <div>
                    <h2 class="dash-title" style="font-size:.975rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">
                        Résumé financier
                    </h2>
                    <p style="font-size:.775rem;color:#444;margin:0;">Performances économiques de la plateforme</p>
                </div>
                <svg width="16" height="16" fill="none" stroke="#333" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
            </div>
            <div class="finance-grid">

                <div class="fin-cell">
                    <p class="section-label" style="margin:0 0 .4rem;">Revenus du mois</p>
                    <p class="dash-title" style="font-size:1.25rem;font-weight:800;color:#f87171;margin:0;line-height:1.1;">
                        {{ number_format($revenusMois, 0, ',', ' ') }}
                        <span style="font-size:.7rem;color:#7f1d1d;font-weight:600;"> FCFA</span>
                    </p>
                </div>

                <div class="fin-cell">
                    <p class="section-label" style="margin:0 0 .4rem;">Commissions générées</p>
                    <p class="dash-title" style="font-size:1.25rem;font-weight:800;color:#4ade80;margin:0;line-height:1.1;">
                        {{ number_format($totalCommissions, 0, ',', ' ') }}
                        <span style="font-size:.7rem;color:#2d6a3f;font-weight:600;"> FCFA</span>
                    </p>
                </div>

                <div class="fin-cell">
                    <p class="section-label" style="margin:0 0 .4rem;">Montant global des dons</p>
                    <p class="dash-title" style="font-size:1.25rem;font-weight:800;color:#fb923c;margin:0;line-height:1.1;">
                        {{ number_format($totalDons, 0, ',', ' ') }}
                        <span style="font-size:.7rem;color:#7c3d12;font-weight:600;"> FCFA</span>
                    </p>
                </div>

                <div class="fin-cell">
                    <p class="section-label" style="margin:0 0 .4rem;">Dossiers en attente</p>
                    <div style="display:flex;align-items:center;gap:.6rem;">
                        <p class="dash-title" style="font-size:1.25rem;font-weight:800;color:#fbbf24;margin:0;line-height:1.1;">
                            {{ number_format($organisateursPending, 0, ',', ' ') }}
                        </p>
                        @if($organisateursPending > 0)
                            <span class="pending-badge">à traiter</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Quick actions --}}
        <div class="section-card fu-4">
            <div class="section-header">
                <div>
                    <h2 class="dash-title" style="font-size:.975rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">
                        Actions rapides
                    </h2>
                    <p style="font-size:.775rem;color:#444;margin:0;">Accès aux tâches principales</p>
                </div>
            </div>

            <div style="padding:1.1rem;display:flex;flex-direction:column;gap:.65rem;">

                <a href="{{ route('admin.validation.organisateur') }}" class="action-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                    <span>Validation organisateurs</span>
                    @if($organisateursPending > 0)
                        <span style="margin-left:auto;background:rgba(255,255,255,.2);
                            font-size:11px;font-weight:800;padding:.1rem .5rem;
                            border-radius:20px;">
                            {{ $organisateursPending }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.validation.organisateur') }}" class="action-btn-ghost">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span>Examiner les documents</span>
                </a>

                {{-- Priority banner --}}
                @if($organisateursPending > 0)
                    <div class="priority-banner" style="margin-top:.35rem;">
                        <div class="pulse-dot"></div>
                        <div>
                            <p style="font-size:.8rem;font-weight:700;color:#fbbf24;margin:0 0 .2rem;">
                                Priorité du jour
                            </p>
                            <p style="font-size:.775rem;color:#7c5a00;margin:0;line-height:1.55;">
                                <strong style="color:#fbbf24;">{{ $organisateursPending }}</strong>
                                organisateur{{ $organisateursPending > 1 ? 's' : '' }}
                                attend{{ $organisateursPending > 1 ? 'ent' : '' }} une décision administrative.
                            </p>
                        </div>
                    </div>
                @else
                    <div style="padding:.85rem 1rem;border-radius:12px;
                        background:rgba(34,197,94,.06);border:1px solid rgba(34,197,94,.15);
                        display:flex;align-items:center;gap:.55rem;margin-top:.35rem;">
                        <svg width="14" height="14" fill="none" stroke="#4ade80" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p style="font-size:.8rem;color:#4ade80;font-weight:500;margin:0;">
                            Aucun dossier en attente — tout est à jour.
                        </p>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>

</x-app-layout>