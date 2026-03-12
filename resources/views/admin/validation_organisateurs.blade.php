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
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .4; transform: scale(.85); }
    }
    .fu   { animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .4s .07s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .4s .14s cubic-bezier(.22,1,.36,1) both; }

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

    /* ── Hero ── */
    .hero-banner {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 20px; overflow: hidden; position: relative;
        padding: 1.75rem 2rem;
    }
    .hero-orb {
        position: absolute; border-radius: 50%;
        filter: blur(80px); pointer-events: none;
    }

    /* ── Dossier card ── */
    .dossier-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px; overflow: hidden;
        transition: border-color .2s, box-shadow .2s;
    }
    .dossier-card:hover { border-color: #242424; box-shadow: 0 6px 28px rgba(0,0,0,.45); }

    .dossier-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; padding: 1.1rem 1.35rem;
        border-bottom: 1px solid #111; flex-wrap: wrap;
    }

    /* ── Meta grid ── */
    .meta-grid {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: .65rem; padding: 1.1rem 1.35rem;
        border-bottom: 1px solid #0f0f0f;
    }
    @media (max-width: 640px) { .meta-grid { grid-template-columns: 1fr 1fr; } }

    .meta-cell {
        background: #0a0a0a; border: 1px solid #141414;
        border-radius: 11px; padding: .75rem .9rem;
    }

    /* ── Body layout ── */
    .dossier-body {
        display: grid; grid-template-columns: 1fr 260px;
        gap: 0;
    }
    @media (max-width: 860px) { .dossier-body { grid-template-columns: 1fr; } }

    .dossier-main { padding: 1.1rem 1.35rem; border-right: 1px solid #0f0f0f; }
    @media (max-width: 860px) { .dossier-main { border-right: none; border-bottom: 1px solid #0f0f0f; } }
    .dossier-side { padding: 1.1rem 1.25rem; display: flex; flex-direction: column; gap: .75rem; }

    /* ── Avatar ── */
    .user-avatar {
        width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, rgba(220,38,38,.25), rgba(249,115,22,.2));
        border: 1.5px solid rgba(249,115,22,.3);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-size: .95rem;
        font-weight: 800; color: #f97316;
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 600;
        padding: .2rem .65rem; border-radius: 20px;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-pending  { background: rgba(251,191,36,.1); color: #fbbf24; border: 1px solid rgba(251,191,36,.25); }
    .badge-pending .badge-dot  { background: #fbbf24; animation: pulse-dot 1.4s infinite; }
    .badge-approved { background: rgba(34,197,94,.1);  color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
    .badge-approved .badge-dot { background: #4ade80; }
    .badge-rejected { background: rgba(220,38,38,.1);  color: #f87171; border: 1px solid rgba(220,38,38,.2); }
    .badge-rejected .badge-dot { background: #f87171; }
    .badge-none     { background: #111; color: #555; border: 1px solid #1e1e1e; }

    /* ── Action buttons ── */
    .btn-view {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1rem; border-radius: 9px;
        border: 1px solid #2a2a2a; background: #111;
        color: #888; font-family: 'DM Sans', sans-serif;
        font-size: .8rem; font-weight: 500; text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
    }
    .btn-view:hover { color: #d0d0d0; border-color: #3a3a3a; background: #161616; }

    .btn-approve {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1rem; border-radius: 9px; border: none;
        background: rgba(34,197,94,.1); color: #4ade80;
        border: 1px solid rgba(34,197,94,.2);
        font-family: 'DM Sans', sans-serif; font-size: .8rem;
        font-weight: 600; cursor: pointer;
        transition: background .2s, border-color .2s, transform .15s;
    }
    .btn-approve:hover { background: rgba(34,197,94,.18); border-color: rgba(34,197,94,.4); transform: translateY(-1px); }

    .btn-reject {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1rem; border-radius: 9px; border: none;
        background: rgba(220,38,38,.08); color: #f87171;
        border: 1px solid rgba(220,38,38,.18);
        font-family: 'DM Sans', sans-serif; font-size: .8rem;
        font-weight: 600; cursor: pointer;
        transition: background .2s, border-color .2s, transform .15s;
    }
    .btn-reject:hover { background: rgba(220,38,38,.15); border-color: rgba(220,38,38,.35); transform: translateY(-1px); }

    /* ── No-doc warning ── */
    .no-doc-banner {
        display: flex; align-items: center; gap: .6rem;
        padding: .8rem 1rem; border-radius: 11px;
        background: rgba(220,38,38,.06); border: 1px solid rgba(220,38,38,.18);
        font-size: .8rem; color: #f87171; font-weight: 500;
    }

    /* ── Verification tip ── */
    .verif-tip {
        display: flex; align-items: flex-start; gap: .55rem;
        padding: .8rem .9rem; border-radius: 11px;
        background: rgba(251,191,36,.06); border: 1px solid rgba(251,191,36,.2);
    }

    /* ── Side info row ── */
    .info-row { display: flex; flex-direction: column; gap: .15rem; }

    /* ── Count chip ── */
    .count-chip {
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; min-width: 22px; height: 20px;
        padding: 0 .5rem; border-radius: 20px;
        background: rgba(251,191,36,.1); color: #fbbf24;
        border: 1px solid rgba(251,191,36,.25);
    }

    /* ── Empty state ── */
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; text-align: center;
        padding: 4rem 2rem; gap: .75rem;
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px;
    }
    .empty-icon {
        width: 54px; height: 54px; border-radius: 14px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .25rem;
    }

    /* ── Pagination ── */
    .pagination-wrap nav { display: flex; justify-content: center; }
</style>

<div class="page" style="max-width:1100px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.5rem;">

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
        <div class="hero-orb" style="width:280px;height:280px;background:rgba(251,191,36,.1);top:-100px;right:-40px;"></div>
        <div class="hero-orb" style="width:180px;height:180px;background:rgba(220,38,38,.07);bottom:-60px;left:25%;"></div>

        <div style="position:relative;display:flex;align-items:flex-start;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
            <div>
                <p class="section-label" style="margin-bottom:.5rem;">Administration</p>
                <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0 0 .5rem;letter-spacing:-.02em;">
                    Validation des organisateurs
                </h1>
                <p style="font-size:.8375rem;color:#555;margin:0;max-width:480px;line-height:1.6;">
                    Consultez les justificatifs déposés et prenez une décision de validation pour chaque dossier.
                </p>
            </div>
            <div style="background:#0a0a0a;border:1px solid rgba(251,191,36,.2);border-radius:13px;padding:.9rem 1.25rem;flex-shrink:0;text-align:center;">
                <p class="section-label" style="color:#7c5a00;margin-bottom:.3rem;">Dossiers en attente</p>
                <p class="dash-title" style="font-size:2.25rem;font-weight:800;color:#fbbf24;margin:0;line-height:1;">
                    {{ $organisateurs->total() }}
                </p>
            </div>
        </div>
    </div>

    {{-- ── List ── --}}
    @if($organisateurs->isEmpty())
        <div class="empty-state fu-2">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
            </div>
            <p style="font-size:.975rem;font-weight:700;color:#666;margin:0;">Aucun dossier en attente</p>
            <p style="font-size:.8rem;color:#3a3a3a;margin:0;line-height:1.55;">
                Tous les dossiers organisateurs ont été traités.
            </p>
            <a href="{{ route('admin.dashboard') }}"
               style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.5rem;
                      padding:.6rem 1.1rem;border-radius:9px;border:none;
                      background:linear-gradient(135deg,#dc2626,#f97316);
                      color:#fff;font-size:.8rem;font-weight:600;
                      font-family:'DM Sans',sans-serif;text-decoration:none;">
                Retour au dashboard
            </a>
        </div>

    @else
        <div style="display:flex;flex-direction:column;gap:1rem;">

            @foreach($organisateurs as $user)
                @php
                    $latestDocument = $user->organisationDocuments->sortByDesc('created_at')->first();
                    $docStatus      = $latestDocument?->status ?? null;
                    $initial        = strtoupper(substr($user->name, 0, 1));
                @endphp

                <div class="dossier-card fu-2">

                    {{-- Card header --}}
                    <div class="dossier-header">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <div class="user-avatar">{{ $initial }}</div>
                            <div>
                                <p style="font-size:.9375rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">
                                    {{ $user->name }}
                                </p>
                                <p style="font-size:.775rem;color:#555;margin:0;">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:.55rem;flex-wrap:wrap;">
                            {{-- User status badge --}}
                            <span class="badge badge-pending">
                                <div class="badge-dot"></div>
                                {{ ucfirst($user->status) }}
                            </span>
                            {{-- Doc status badge --}}
                            @if($latestDocument)
                                @if($docStatus === 'pending')
                                    <span class="badge badge-pending">
                                        <div class="badge-dot"></div> Doc en attente
                                    </span>
                                @elseif($docStatus === 'approved')
                                    <span class="badge badge-approved">
                                        <div class="badge-dot"></div> Doc approuvé
                                    </span>
                                @else
                                    <span class="badge badge-rejected">
                                        <div class="badge-dot"></div> Doc rejeté
                                    </span>
                                @endif
                            @else
                                <span class="badge badge-none">Aucun document</span>
                            @endif
                        </div>
                    </div>

                    {{-- Meta strip --}}
                    <div class="meta-grid">
                        <div class="meta-cell">
                            <p class="section-label" style="margin:0 0 .3rem;">Inscription</p>
                            <p style="font-size:.8375rem;font-weight:600;color:#d0d0d0;margin:0;">
                                {{ $user->created_at->format('d/m/Y') }}
                            </p>
                            <p style="font-size:.72rem;color:#3a3a3a;margin:.1rem 0 0;">
                                {{ $user->created_at->format('H:i') }}
                            </p>
                        </div>
                        <div class="meta-cell">
                            <p class="section-label" style="margin:0 0 .3rem;">Dernier dépôt</p>
                            <p style="font-size:.8375rem;font-weight:600;color:#d0d0d0;margin:0;">
                                @if($latestDocument)
                                    {{ $latestDocument->created_at->format('d/m/Y') }}
                                @else
                                    <span style="color:#333;">—</span>
                                @endif
                            </p>
                            <p style="font-size:.72rem;color:#3a3a3a;margin:.1rem 0 0;">
                                @if($latestDocument) {{ $latestDocument->created_at->format('H:i') }} @endif
                            </p>
                        </div>
                        <div class="meta-cell">
                            <p class="section-label" style="margin:0 0 .3rem;">Rôle</p>
                            <p style="font-size:.8375rem;font-weight:600;color:#fb923c;margin:0;">Organisateur</p>
                        </div>
                    </div>

                    {{-- Body: actions + sidebar --}}
                    <div class="dossier-body">

                        {{-- Main: actions --}}
                        <div class="dossier-main">

                            @if($latestDocument)
                                <p class="section-label" style="margin-bottom:.75rem;">Actions sur le dossier</p>

                                <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">

                                    {{-- View doc --}}
                                    <a href="{{ route('admin.documents.show', $latestDocument) }}"
                                       target="_blank" class="btn-view">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                        </svg>
                                        Consulter le document
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </a>

                                    {{-- Approve --}}
                                    <form method="POST" action="{{ route('admin.documents.approve', $latestDocument) }}">
                                        @csrf
                                        <button type="submit" class="btn-approve">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Approuver
                                        </button>
                                    </form>

                                    {{-- Reject --}}
                                    <form method="POST" action="{{ route('admin.documents.reject', $latestDocument) }}">
                                        @csrf
                                        <button type="submit" class="btn-reject">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Rejeter
                                        </button>
                                    </form>

                                </div>

                                {{-- Verification tip --}}
                                <div class="verif-tip" style="margin-top:1rem;">
                                    <svg width="13" height="13" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                    </svg>
                                    <p style="font-size:.775rem;color:#7c5a00;margin:0;line-height:1.55;">
                                        <strong style="color:#fbbf24;">Consultez le justificatif</strong>
                                        avant d'approuver ou de rejeter le compte.
                                    </p>
                                </div>

                            @else
                                <div class="no-doc-banner">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                    </svg>
                                    Aucun document déposé par cet organisateur — en attente de dépôt.
                                </div>
                            @endif

                        </div>

                        {{-- Sidebar: résumé dossier --}}
                        <div class="dossier-side">
                            <p class="section-label">Résumé dossier</p>

                            <div class="info-row">
                                <span style="font-size:.72rem;color:#3a3a3a;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Nom</span>
                                <span style="font-size:.8375rem;font-weight:600;color:#d0d0d0;">{{ $user->name }}</span>
                            </div>
                            <div style="height:1px;background:#0f0f0f;"></div>

                            <div class="info-row">
                                <span style="font-size:.72rem;color:#3a3a3a;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Email</span>
                                <span style="font-size:.8rem;font-weight:500;color:#888;word-break:break-all;">{{ $user->email }}</span>
                            </div>
                            <div style="height:1px;background:#0f0f0f;"></div>

                            <div class="info-row">
                                <span style="font-size:.72rem;color:#3a3a3a;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Inscription</span>
                                <span style="font-size:.8375rem;font-weight:600;color:#d0d0d0;">
                                    {{ $user->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                            <div style="height:1px;background:#0f0f0f;"></div>

                            <div class="info-row">
                                <span style="font-size:.72rem;color:#3a3a3a;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Dernier dépôt</span>
                                <span style="font-size:.8375rem;font-weight:600;color:#d0d0d0;">
                                    @if($latestDocument)
                                        {{ $latestDocument->created_at->format('d/m/Y à H:i') }}
                                    @else
                                        <span style="color:#333;">Non disponible</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        </div>

        {{-- Pagination --}}
        @if($organisateurs->hasPages())
            <div class="pagination-wrap fu-3">
                {{ $organisateurs->links() }}
            </div>
        @endif

    @endif

</div>

</x-app-layout>