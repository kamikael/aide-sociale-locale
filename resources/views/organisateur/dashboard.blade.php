<x-app-layout>

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .dash { font-family: 'DM Sans', sans-serif; }
    .dash-title { font-family: 'Syne', sans-serif; }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fu { animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .45s .07s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .45s .14s cubic-bezier(.22,1,.36,1) both; }
    .fu-4 { animation: fadeUp .45s .21s cubic-bezier(.22,1,.36,1) both; }

    /* ── Hero banner ── */
    .hero-banner {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        background: #0d0d0d;
        border: 1px solid #1e1e1e;
        padding: 2rem 2rem;
    }
    .hero-banner::before {
        content: '';
        position: absolute;
        top: -40%; left: -10%;
        width: 55%; height: 200%;
        background: radial-gradient(ellipse, rgba(220,38,38,.1) 0%, transparent 65%);
        pointer-events: none;
    }
    .hero-banner::after {
        content: '';
        position: absolute;
        top: -20%; right: -5%;
        width: 40%; height: 150%;
        background: radial-gradient(ellipse, rgba(249,115,22,.07) 0%, transparent 60%);
        pointer-events: none;
    }

    /* ── Stat cards ── */
    .stat-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 14px;
        padding: 1.35rem 1.5rem;
        position: relative;
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s;
    }
    .stat-card:hover {
        border-color: #2a2a2a;
        box-shadow: 0 4px 20px rgba(0,0,0,.35);
    }
    .stat-card-accent {
        position: absolute;
        top: 0; left: 0;
        width: 3px; height: 100%;
        border-radius: 3px 0 0 3px;
    }
    .stat-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    /* ── Section cards ── */
    .section-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
    }
    .section-card-body { padding: 1.5rem; }
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #141414;
    }

    /* ── Info box (docs acceptés) ── */
    .info-box {
        border: 1px dashed #2a2a2a;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        background: rgba(249,115,22,.04);
    }

    /* ── Alert banners ── */
    .alert-success {
        display: flex; align-items: flex-start; gap: .65rem;
        padding: .85rem 1.1rem;
        border-radius: 12px;
        background: rgba(34,197,94,.07);
        border: 1px solid rgba(34,197,94,.2);
    }
    .alert-error {
        display: flex; align-items: flex-start; gap: .65rem;
        padding: .85rem 1.1rem;
        border-radius: 12px;
        background: rgba(220,38,38,.07);
        border: 1px solid rgba(220,38,38,.2);
    }
    .alert-warning {
        display: flex; align-items: flex-start; gap: .65rem;
        padding: .85rem 1.1rem;
        border-radius: 12px;
        background: rgba(249,115,22,.07);
        border: 1px solid rgba(249,115,22,.2);
    }

    /* ── Status badge ── */
    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 600;
        padding: .2rem .65rem;
        border-radius: 20px;
        letter-spacing: .02em;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-active   { background: rgba(34,197,94,.1);  color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
    .badge-active .badge-dot   { background: #4ade80; }
    .badge-closed   { background: rgba(100,100,100,.1); color: #888; border: 1px solid #222; }
    .badge-closed .badge-dot   { background: #666; }
    .badge-suspended{ background: rgba(220,38,38,.1);  color: #f87171; border: 1px solid rgba(220,38,38,.2); }
    .badge-suspended .badge-dot{ background: #f87171; }
    .badge-pending  { background: rgba(249,115,22,.1); color: #fb923c; border: 1px solid rgba(249,115,22,.2); }
    .badge-pending .badge-dot  { background: #fb923c; }
    .badge-validated{ background: rgba(34,197,94,.1);  color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
    .badge-validated .badge-dot{ background: #4ade80; }
    .badge-rejected { background: rgba(220,38,38,.1);  color: #f87171; border: 1px solid rgba(220,38,38,.2); }
    .badge-rejected .badge-dot { background: #f87171; }

    /* ── Table ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr {
        border-bottom: 1px solid #161616;
    }
    .data-table thead th {
        padding: .85rem 1.25rem;
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #444;
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid #111;
        transition: background .15s;
    }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: rgba(255,255,255,.025); }
    .data-table tbody td {
        padding: 1rem 1.25rem;
        font-size: .8375rem;
        color: #999;
        vertical-align: middle;
    }

    /* ── Progress bar ── */
    .prog-track {
        height: 4px;
        border-radius: 4px;
        background: #1a1a1a;
        overflow: hidden;
        margin-bottom: 4px;
    }
    .prog-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #dc2626, #f97316);
        transition: width .4s ease;
    }

    /* ── Action buttons ── */
    .btn-primary {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.1rem;
        border-radius: 9px;
        border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .8125rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 3px 14px rgba(220,38,38,.28);
        transition: filter .2s, transform .15s, box-shadow .2s;
        white-space: nowrap;
    }
    .btn-primary:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
        box-shadow: 0 5px 20px rgba(220,38,38,.38);
    }
    .btn-primary:active { transform: translateY(0); }

    .btn-secondary {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.1rem;
        border-radius: 9px;
        border: 1px solid #222;
        background: transparent;
        color: #888;
        font-family: 'DM Sans', sans-serif;
        font-size: .8125rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
        white-space: nowrap;
    }
    .btn-secondary:hover { color: #d0d0d0; border-color: #333; background: rgba(255,255,255,.04); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem .9rem;
        border-radius: 9px;
        border: 1px solid #1a1a1a;
        background: #111;
        color: #777;
        font-family: 'DM Sans', sans-serif;
        font-size: .8125rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
        white-space: nowrap;
    }
    .btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: #161616; }

    /* ── File input ── */
    .file-zone {
        position: relative;
        border: 1.5px dashed #222;
        border-radius: 12px;
        background: #0a0a0a;
        padding: 1.5rem;
        text-align: center;
        transition: border-color .2s;
        cursor: pointer;
    }
    .file-zone:hover { border-color: rgba(249,115,22,.4); }
    .file-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }

    /* ── Action card ── */
    .action-card {
        display: flex;
        flex-direction: column;
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 14px;
        padding: 1.35rem;
        transition: border-color .2s, box-shadow .2s;
        text-decoration: none;
    }
    .action-card:hover {
        border-color: #2a2a2a;
        box-shadow: 0 4px 20px rgba(0,0,0,.3);
    }
    .action-card-icon {
        width: 40px; height: 40px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1rem;
    }

    /* ── Empty state ── */
    .empty-state {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 3.5rem 2rem;
        text-align: center;
        gap: .75rem;
    }
    .empty-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: #111;
        border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .25rem;
    }

    /* ── Section label ── */
    .section-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #444;
        margin-bottom: .75rem;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .hero-banner { padding: 1.5rem; }
        .stat-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .stat-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dash" style="max-width:1200px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.5rem;">

    {{-- ══════════════ FLASH MESSAGES ══════════════ --}}
    @if(session('success'))
        <div class="alert-success fu">
            <svg width="15" height="15" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:.8375rem;color:#86efac;margin:0;">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error fu">
            <svg width="15" height="15" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            <p style="font-size:.8375rem;color:#fca5a5;margin:0;">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ══════════════ HERO BANNER ══════════════ --}}
    <section class="hero-banner fu">
        <div style="position:relative;z-index:1;display:grid;gap:1.5rem;align-items:center;"
             class="lg:grid-cols-3">

            {{-- Left --}}
            <div style="grid-column:span 2;">
                <p class="section-label" style="color:rgba(249,115,22,.7);margin-bottom:.5rem;">
                    Dashboard organisateur
                </p>
                <h1 class="dash-title" style="font-size:1.75rem;font-weight:800;color:#f0f0f0;margin:0 0 .6rem;letter-spacing:-.02em;line-height:1.15;">
                    Bonjour, {{ $user->name }} 👋
                </h1>
                <p style="font-size:.875rem;color:#555;max-width:520px;line-height:1.6;margin:0;">
                    Suivez vos cagnottes, envoyez vos justificatifs et gérez votre espace organisateur.
                </p>
            </div>

            {{-- Status chip --}}
            <div style="background:rgba(255,255,255,.03);border:1px solid #1e1e1e;border-radius:14px;padding:1.1rem 1.25rem;">
                <p style="font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#444;margin:0 0 .6rem;">
                    Statut du compte
                </p>
                @if($isValidated)
                    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.5rem;">
                        <div style="width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 6px #4ade80;flex-shrink:0;"></div>
                        <span class="dash-title" style="font-size:1.1rem;font-weight:700;color:#f0f0f0;">Validé</span>
                    </div>
                    <p style="font-size:.775rem;color:#555;margin:0;line-height:1.55;">
                        Vous pouvez créer des cagnottes et consulter votre historique.
                    </p>
                @elseif($user->status === 'pending')
                    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.5rem;">
                        <div style="width:8px;height:8px;border-radius:50%;background:#fb923c;box-shadow:0 0 6px rgba(249,115,22,.6);flex-shrink:0;"></div>
                        <span class="dash-title" style="font-size:1.1rem;font-weight:700;color:#f0f0f0;">En attente</span>
                    </div>
                    <p style="font-size:.775rem;color:#555;margin:0;line-height:1.55;">
                        Votre dossier est en cours d'examen par l'administrateur.
                    </p>
                @else
                    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.5rem;">
                        <div style="width:8px;height:8px;border-radius:50%;background:#f87171;flex-shrink:0;"></div>
                        <span class="dash-title" style="font-size:1.1rem;font-weight:700;color:#f0f0f0;">Non validé</span>
                    </div>
                    <p style="font-size:.775rem;color:#555;margin:0;line-height:1.55;">
                        Déposez un justificatif pour débloquer la création de cagnotte.
                    </p>
                @endif
            </div>

        </div>
    </section>

    {{-- ══════════════ STATS ══════════════ --}}
    <section class="stat-grid fu-2" style="display:grid;gap:1rem;grid-template-columns:repeat(3,1fr);">

        {{-- Cagnottes --}}
        <div class="stat-card">
            <div class="stat-card-accent" style="background:linear-gradient(180deg,#dc2626,#f97316);"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem;">
                <div class="stat-icon" style="background:rgba(220,38,38,.1);">
                    <svg width="16" height="16" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:#444;margin:0 0 .4rem;">Cagnottes créées</p>
            <p class="dash-title" style="font-size:2rem;font-weight:800;color:#f0f0f0;margin:0;line-height:1;">
                {{ $nombreCagnottes }}
            </p>
        </div>

        {{-- Collecté --}}
        <div class="stat-card">
            <div class="stat-card-accent" style="background:linear-gradient(180deg,#16a34a,#4ade80);"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem;">
                <div class="stat-icon" style="background:rgba(34,197,94,.08);">
                    <svg width="16" height="16" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:#444;margin:0 0 .4rem;">Total collecté</p>
            <p class="dash-title" style="font-size:1.6rem;font-weight:800;color:#4ade80;margin:0;line-height:1;">
                {{ number_format($totalCollected, 0, ',', ' ') }}
                <span style="font-size:.9rem;font-weight:600;color:#2d6a3f;">FCFA</span>
            </p>
        </div>

        {{-- Objectif --}}
        <div class="stat-card">
            <div class="stat-card-accent" style="background:linear-gradient(180deg,#f97316,#fbbf24);"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem;">
                <div class="stat-icon" style="background:rgba(249,115,22,.08);">
                    <svg width="16" height="16" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:#444;margin:0 0 .4rem;">Objectif cumulé</p>
            <p class="dash-title" style="font-size:1.6rem;font-weight:800;color:#fb923c;margin:0;line-height:1;">
                {{ number_format($totalTarget, 0, ',', ' ') }}
                <span style="font-size:.9rem;font-weight:600;color:#7c3d12;">FCFA</span>
            </p>
        </div>

    </section>

    {{-- ══════════════ CAS NON VALIDÉ ══════════════ --}}
    @if(!$isValidated)
        <section class="fu-3" style="display:grid;gap:1.25rem;grid-template-columns:1fr 1fr;">

            {{-- Validation info --}}
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h2 class="dash-title" style="font-size:1rem;font-weight:700;color:#e0e0e0;margin:0 0 .2rem;">Validation du compte</h2>
                        <p style="font-size:.775rem;color:#555;margin:0;">Documents requis pour débloquer la création de cagnotte</p>
                    </div>
                    <div class="badge badge-pending">
                        <div class="badge-dot"></div>
                        En attente
                    </div>
                </div>

                <div class="section-card-body" style="display:flex;flex-direction:column;gap:1rem;">
                    <div class="info-box">
                        <p style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#f97316;margin:0 0 .75rem;">
                            Documents acceptés
                        </p>
                        <ul style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:.5rem;">
                            @foreach(['Récépissé d\'association','Registre de commerce','Attestation officielle','Tout document légal équivalent'] as $doc)
                                <li style="display:flex;align-items:center;gap:.6rem;font-size:.8125rem;color:#777;">
                                    <svg width="13" height="13" fill="none" stroke="#f97316" stroke-width="2.2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $doc }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if($latestDocument)
                        <div style="background:#111;border:1px solid #1a1a1a;border-radius:11px;padding:1rem 1.1rem;">
                            <p style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#444;margin:0 0 .65rem;">Dernier document envoyé</p>
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;">
                                <p style="font-size:.775rem;color:#666;margin:0;">
                                    Déposé le {{ $latestDocument->created_at->format('d/m/Y à H:i') }}
                                </p>
                                @php $s = $latestDocument->status; @endphp
                                <span class="badge {{ $s === 'pending' ? 'badge-pending' : ($s === 'validated' ? 'badge-validated' : 'badge-rejected') }}">
                                    <div class="badge-dot"></div>
                                    {{ ucfirst($s) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <div class="alert-warning">
                        <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        <p style="font-size:.775rem;color:#c2720a;margin:0;line-height:1.55;">
                            Création de cagnotte <strong style="color:#fb923c;">bloquée</strong> jusqu'à la validation de votre dossier.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Upload doc --}}
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h2 class="dash-title" style="font-size:1rem;font-weight:700;color:#e0e0e0;margin:0 0 .2rem;">Déposer un justificatif</h2>
                        <p style="font-size:.775rem;color:#555;margin:0;">Envoyez votre document pour demander la validation</p>
                    </div>
                </div>

                <div class="section-card-body">
                    @if($latestDocument && $latestDocument->status === 'pending')
                        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1rem;text-align:center;gap:.75rem;">
                            <div style="width:48px;height:48px;border-radius:13px;background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.2);display:flex;align-items:center;justify-content:center;margin-bottom:.25rem;">
                                <svg width="20" height="20" fill="none" stroke="#fb923c" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p style="font-size:.875rem;font-weight:600;color:#e0e0e0;margin:0;">Document en cours de validation</p>
                            <p style="font-size:.775rem;color:#555;margin:0;line-height:1.55;max-width:280px;">
                                Attendez la décision de l'administrateur avant d'envoyer un nouveau document.
                            </p>
                            <span class="badge badge-pending" style="margin-top:.25rem;">
                                <div class="badge-dot"></div> En cours d'examen
                            </span>
                        </div>
                    @else
                        <form action="{{ route('organisateur.documents.store') }}" method="POST" enctype="multipart/form-data"
                              style="display:flex;flex-direction:column;gap:1.1rem;">
                            @csrf

                            <div class="file-zone" id="file-zone">
                                <input type="file" id="document" name="document" required
                                       onchange="updateFileLabel(this)" />
                                <div id="file-label" style="pointer-events:none;">
                                    <div style="width:40px;height:40px;border-radius:11px;background:#111;border:1px solid #1e1e1e;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                                        <svg width="18" height="18" fill="none" stroke="#555" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.8125rem;font-weight:600;color:#666;margin:0 0 .25rem;">
                                        Glissez votre fichier ou <span style="color:#f97316;">parcourir</span>
                                    </p>
                                    <p style="font-size:.75rem;color:#444;margin:0;">PDF, JPG, PNG — max 10 Mo</p>
                                </div>
                            </div>

                            @error('document')
                                <p style="font-size:.775rem;color:#fca5a5;margin:0;">{{ $message }}</p>
                            @enderror

                            <button type="submit" class="btn-primary" style="align-self:flex-start;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                                Envoyer le document
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </section>
    @endif

    {{-- ══════════════ CAS VALIDÉ — ACTIONS RAPIDES ══════════════ --}}
    @if($isValidated)
        <section class="fu-3" style="display:grid;gap:1rem;grid-template-columns:repeat(3,1fr);">

            {{-- Créer cagnotte --}}
            <a href="{{ route('organisateur.cagnottes.create') }}" class="action-card">
                <div class="action-card-icon" style="background:linear-gradient(135deg,rgba(220,38,38,.15),rgba(249,115,22,.12));border:1px solid rgba(249,115,22,.2);">
                    <svg width="18" height="18" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                </div>
                <p style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .35rem;">Créer une cagnotte</p>
                <p style="font-size:.775rem;color:#555;margin:0 0 1rem;line-height:1.5;flex:1;">Lancez une nouvelle campagne pour votre cause.</p>
                <span class="btn-primary" style="align-self:flex-start;font-size:.775rem;padding:.5rem .9rem;">
                    Commencer
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </span>
            </a>

            {{-- Mes cagnottes --}}
            <a href="{{ route('organisateur.cagnottes') }}" class="action-card">
                <div class="action-card-icon" style="background:rgba(255,255,255,.04);border:1px solid #1e1e1e;">
                    <svg width="18" height="18" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                    </svg>
                </div>
                <p style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .35rem;">Mes cagnottes</p>
                <p style="font-size:.775rem;color:#555;margin:0 0 1rem;line-height:1.5;flex:1;">Consultez et gérez toutes vos campagnes.</p>
                <span class="btn-ghost" style="align-self:flex-start;font-size:.775rem;padding:.5rem .9rem;">
                    Voir tout
                </span>
            </a>

            {{-- Profil --}}
            <a href="{{ route('profile.edit') }}" class="action-card">
                <div class="action-card-icon" style="background:rgba(255,255,255,.04);border:1px solid #1e1e1e;">
                    <svg width="18" height="18" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <p style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .35rem;">Mon profil</p>
                <p style="font-size:.775rem;color:#555;margin:0 0 1rem;line-height:1.5;flex:1;">Modifiez vos informations personnelles.</p>
                <span class="btn-ghost" style="align-self:flex-start;font-size:.775rem;padding:.5rem .9rem;">
                    Modifier
                </span>
            </a>

        </section>

        {{-- ══════════════ TABLEAU DES CAGNOTTES ══════════════ --}}
        <section class="section-card fu-4">
            <div class="section-header">
                <div>
                    <h2 class="dash-title" style="font-size:1rem;font-weight:700;color:#e0e0e0;margin:0 0 .2rem;">
                        Historique des cagnottes
                    </h2>
                    <p style="font-size:.775rem;color:#555;margin:0;">
                        {{ $cagnottes->count() }} cagnotte{{ $cagnottes->count() > 1 ? 's' : '' }} au total
                    </p>
                </div>
                <a href="{{ route('organisateur.cagnottes.create') }}" class="btn-primary" style="font-size:.775rem;padding:.55rem .9rem;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Nouvelle
                </a>
            </div>

            @if($cagnottes->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="22" height="22" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <p style="font-size:.9rem;font-weight:600;color:#888;margin:0;">Aucune cagnotte pour le moment</p>
                    <p style="font-size:.775rem;color:#444;margin:0;">Commencez par créer votre première cagnotte.</p>
                    <a href="{{ route('organisateur.cagnottes.create') }}" class="btn-primary" style="margin-top:.5rem;font-size:.8125rem;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Créer ma première cagnotte
                    </a>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Cagnotte</th>
                                <th>Collecté</th>
                                <th>Objectif</th>
                                <th style="min-width:160px;">Progression</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cagnottes as $cagnotte)
                                @php
                                    $progress = $cagnotte->target_amount > 0
                                        ? min(100, round(($cagnotte->collected_amount / $cagnotte->target_amount) * 100))
                                        : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <p style="font-weight:600;color:#d0d0d0;margin:0 0 .2rem;font-size:.8375rem;">
                                            {{ $cagnotte->title }}
                                        </p>
                                        @if($cagnotte->published_at)
                                            <p style="font-size:.75rem;color:#444;margin:0;">
                                                Publiée le {{ \Carbon\Carbon::parse($cagnotte->published_at)->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-weight:700;color:#4ade80;font-size:.8375rem;">
                                            {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }}
                                        </span>
                                        <span style="font-size:.7rem;color:#2d6a3f;font-weight:500;"> FCFA</span>
                                    </td>
                                    <td>
                                        <span style="font-weight:600;color:#fb923c;font-size:.8375rem;">
                                            {{ number_format($cagnotte->target_amount, 0, ',', ' ') }}
                                        </span>
                                        <span style="font-size:.7rem;color:#7c3d12;font-weight:500;"> FCFA</span>
                                    </td>
                                    <td>
                                        <div class="prog-track">
                                            <div class="prog-fill" style="width:{{ $progress }}%;"></div>
                                        </div>
                                        <span style="font-size:.75rem;font-weight:600;color:{{ $progress >= 100 ? '#4ade80' : '#666' }};">
                                            {{ $progress }}%
                                        </span>
                                    </td>
                                    <td>
                                        @if($cagnotte->status === 'active')
                                            <span class="badge badge-active"><div class="badge-dot"></div>Active</span>
                                        @elseif($cagnotte->status === 'closed')
                                            <span class="badge badge-closed"><div class="badge-dot"></div>Clôturée</span>
                                        @else
                                            <span class="badge badge-suspended"><div class="badge-dot"></div>Suspendue</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    @endif

</div>

<script>
function updateFileLabel(input) {
    const label = document.getElementById('file-label');
    const zone  = document.getElementById('file-zone');
    if (input.files && input.files[0]) {
        const name = input.files[0].name;
        const size = (input.files[0].size / 1024).toFixed(0) + ' Ko';
        zone.style.borderColor = 'rgba(249,115,22,.5)';
        zone.style.background  = 'rgba(249,115,22,.04)';
        label.innerHTML = `
            <div style="display:flex;align-items:center;gap:.65rem;justify-content:center;">
                <div style="width:36px;height:36px;border-radius:9px;background:rgba(249,115,22,.1);border:1px solid rgba(249,115,22,.2);display:flex;align-items:center;justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <div style="text-align:left;">
                    <p style="font-size:.8125rem;font-weight:600;color:#f97316;margin:0;">${name}</p>
                    <p style="font-size:.75rem;color:#555;margin:0;">${size}</p>
                </div>
            </div>
        `;
    }
}
</script>

</x-app-layout>