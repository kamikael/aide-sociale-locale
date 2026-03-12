<x-app-layout>

<style>
    *, *::before, *::after { box-sizing: border-box; }
    .page { font-family: 'DM Sans', sans-serif; }
    .dash-title { font-family: 'Syne', sans-serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fu   { animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .4s .07s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .4s .14s cubic-bezier(.22,1,.36,1) both; }

    /* ── Stat cards ── */
    .stat-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        position: relative;
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s;
    }
    .stat-card:hover { border-color: #2a2a2a; box-shadow: 0 4px 20px rgba(0,0,0,.35); }
    .stat-card-accent {
        position: absolute; top: 0; left: 0;
        width: 3px; height: 100%; border-radius: 3px 0 0 3px;
    }
    .stat-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .9rem;
    }

    /* ── Section card ── */
    .section-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
    }
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; padding: 1.1rem 1.35rem;
        border-bottom: 1px solid #111;
        flex-wrap: wrap;
    }

    /* ── Filter bar ── */
    .filter-bar {
        display: flex; align-items: center; gap: .55rem;
        flex-wrap: wrap;
    }
    .filter-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .38rem .8rem; border-radius: 8px;
        border: 1px solid #1e1e1e; background: transparent;
        font-family: 'DM Sans', sans-serif; font-size: .775rem;
        font-weight: 500; color: #555; cursor: pointer;
        transition: color .2s, border-color .2s, background .2s;
        white-space: nowrap;
    }
    .filter-btn:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }
    .filter-btn.active {
        color: #f97316; border-color: rgba(249,115,22,.35);
        background: rgba(249,115,22,.08);
    }
    .filter-dot { width: 5px; height: 5px; border-radius: 50%; }

    /* ── Search input ── */
    .search-wrap { position: relative; }
    .search-input {
        background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #d0d0d0; border-radius: 9px;
        padding: .4rem .9rem .4rem 2.2rem;
        font-size: .8rem; font-family: 'DM Sans', sans-serif;
        outline: none; width: 200px;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
    .search-input::placeholder { color: #333; }
    .search-icon {
        position: absolute; left: .65rem; top: 50%;
        transform: translateY(-50%); pointer-events: none; color: #333;
    }

    /* ── Table ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { border-bottom: 1px solid #141414; }
    .data-table thead th {
        padding: .85rem 1.25rem; text-align: left;
        font-size: 10.5px; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: #444;
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid #0f0f0f;
        transition: background .15s;
    }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: rgba(255,255,255,.02); }
    .data-table tbody td {
        padding: 1rem 1.25rem; font-size: .8375rem;
        color: #888; vertical-align: middle;
    }
    .data-table tbody tr.hidden-row { display: none; }

    /* ── Progress ── */
    .prog-track {
        height: 3px; border-radius: 4px;
        background: #1a1a1a; overflow: hidden; margin-bottom: 3px;
    }
    .prog-fill {
        height: 100%; border-radius: 4px;
        background: linear-gradient(90deg, #dc2626, #f97316);
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 600;
        padding: .2rem .65rem; border-radius: 20px; letter-spacing: .02em;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-active    { background: rgba(34,197,94,.1);   color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
    .badge-active    .badge-dot { background: #4ade80; box-shadow: 0 0 4px #4ade80; }
    .badge-closed    { background: rgba(100,100,100,.1); color: #888;    border: 1px solid #222; }
    .badge-closed    .badge-dot { background: #555; }
    .badge-suspended { background: rgba(220,38,38,.1);   color: #f87171; border: 1px solid rgba(220,38,38,.2); }
    .badge-suspended .badge-dot { background: #f87171; }
    .badge-pending   { background: rgba(249,115,22,.1);  color: #fb923c; border: 1px solid rgba(249,115,22,.2); }
    .badge-pending   .badge-dot { background: #fb923c; }

    /* ── Empty ── */
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; text-align: center;
        padding: 3.5rem 2rem; gap: .7rem;
    }
    .empty-icon {
        width: 50px; height: 50px; border-radius: 13px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .25rem;
    }

    /* ── Count chip ── */
    .count-chip {
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; min-width: 20px; height: 20px;
        padding: 0 .45rem; border-radius: 20px;
        background: rgba(249,115,22,.1); color: #f97316;
        border: 1px solid rgba(249,115,22,.2);
    }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* ── Taux global bar ── */
    .global-rate-bar {
        height: 6px; border-radius: 6px; background: #141414; overflow: hidden;
    }
    .global-rate-fill {
        height: 100%; border-radius: 6px;
        background: linear-gradient(90deg, #dc2626, #f97316);
        transition: width .6s ease;
    }

    @media (max-width: 640px) {
        .stat-grid-3 { grid-template-columns: 1fr !important; }
        .search-input { width: 100%; }
        .filter-bar { width: 100%; }
        .data-table thead th:nth-child(3),
        .data-table tbody td:nth-child(3) { display: none; }
    }
    @media (max-width: 900px) {
        .stat-grid-3 { grid-template-columns: 1fr 1fr !important; }
    }
</style>

<div class="page" style="max-width:1200px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.5rem;">

    {{-- ══ HEADER ══ --}}
    <div class="fu" style="display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <div>
            <p class="section-label" style="margin-bottom:.4rem;">Organisateur</p>
            <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
                Historique des cagnottes
            </h1>
        </div>
        @php
            $globalRate = ($totalTarget > 0)
                ? min(100, round(($totalCollected / $totalTarget) * 100))
                : 0;
        @endphp
        <div style="text-align:right;">
            <p class="section-label" style="margin-bottom:.35rem;">Taux global de collecte</p>
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div class="global-rate-bar" style="width:140px;">
                    <div class="global-rate-fill" style="width:{{ $globalRate }}%;"></div>
                </div>
                <span class="dash-title" style="font-size:1rem;font-weight:800;color:{{ $globalRate >= 80 ? '#4ade80' : ($globalRate >= 40 ? '#fb923c' : '#f87171') }};">
                    {{ $globalRate }}%
                </span>
            </div>
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="stat-grid-3 fu-2" style="display:grid;gap:1rem;grid-template-columns:repeat(3,1fr);">

        <div class="stat-card">
            <div class="stat-card-accent" style="background:linear-gradient(180deg,#dc2626,#f97316);"></div>
            <div class="stat-icon" style="background:rgba(220,38,38,.1);">
                <svg width="15" height="15" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Cagnottes totales</p>
            <p class="dash-title" style="font-size:2rem;font-weight:800;color:#f0f0f0;margin:0;line-height:1;">
                {{ $cagnottes->count() }}
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-card-accent" style="background:linear-gradient(180deg,#16a34a,#4ade80);"></div>
            <div class="stat-icon" style="background:rgba(34,197,94,.08);">
                <svg width="15" height="15" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Total collecté</p>
            <p class="dash-title" style="font-size:1.65rem;font-weight:800;color:#4ade80;margin:0;line-height:1;">
                {{ number_format($totalCollected, 0, ',', ' ') }}
                <span style="font-size:.85rem;font-weight:600;color:#2d6a3f;">FCFA</span>
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-card-accent" style="background:linear-gradient(180deg,#f97316,#fbbf24);"></div>
            <div class="stat-icon" style="background:rgba(249,115,22,.08);">
                <svg width="15" height="15" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .35rem;">Objectif total</p>
            <p class="dash-title" style="font-size:1.65rem;font-weight:800;color:#fb923c;margin:0;line-height:1;">
                {{ number_format($totalTarget, 0, ',', ' ') }}
                <span style="font-size:.85rem;font-weight:600;color:#7c3d12;">FCFA</span>
            </p>
        </div>

    </div>

    {{-- ══ TABLE ══ --}}
    <div class="section-card fu-3">

        {{-- Header table --}}
        <div class="section-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <h2 class="dash-title" style="font-size:.975rem;font-weight:700;color:#e0e0e0;margin:0;">
                    Toutes les cagnottes
                </h2>
                <span class="count-chip" id="visible-count">{{ $cagnottes->count() }}</span>
            </div>

            <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
                {{-- Search --}}
                <div class="search-wrap">
                    <svg class="search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text" class="search-input" id="search-input"
                           placeholder="Rechercher…" oninput="applyFilters()" />
                </div>

                {{-- Filters --}}
                <div class="filter-bar">
                    <button class="filter-btn active" data-filter="all" onclick="setFilter('all',this)">
                        Tous
                    </button>
                    <button class="filter-btn" data-filter="active" onclick="setFilter('active',this)">
                        <span class="filter-dot" style="background:#4ade80;"></span> Actives
                    </button>
                    <button class="filter-btn" data-filter="closed" onclick="setFilter('closed',this)">
                        <span class="filter-dot" style="background:#555;"></span> Clôturées
                    </button>
                    <button class="filter-btn" data-filter="suspended" onclick="setFilter('suspended',this)">
                        <span class="filter-dot" style="background:#f87171;"></span> Suspendues
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table class="data-table" id="main-table">
                <thead>
                    <tr>
                        <th>Cagnotte</th>
                        <th>Progression</th>
                        <th>Collecté</th>
                        <th>Objectif</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cagnottes as $cagnotte)
                        @php
                            $progress = $cagnotte->target_amount > 0
                                ? min(100, round(($cagnotte->collected_amount / $cagnotte->target_amount) * 100))
                                : 0;
                            $statusClass = match($cagnotte->status) {
                                'active'    => 'badge-active',
                                'closed'    => 'badge-closed',
                                'suspended' => 'badge-suspended',
                                default     => 'badge-pending',
                            };
                            $statusLabel = match($cagnotte->status) {
                                'active'    => 'Active',
                                'closed'    => 'Clôturée',
                                'suspended' => 'Suspendue',
                                default     => ucfirst($cagnotte->status),
                            };
                        @endphp
                        <tr data-status="{{ $cagnotte->status }}" data-title="{{ strtolower($cagnotte->title) }}">

                            {{-- Title --}}
                            <td>
                                <p style="font-weight:600;color:#d0d0d0;margin:0 0 .15rem;font-size:.8375rem;">
                                    {{ $cagnotte->title }}
                                </p>
                                @if($cagnotte->description)
                                    <p style="font-size:.75rem;color:#3a3a3a;margin:0;
                                              display:-webkit-box;-webkit-line-clamp:1;
                                              -webkit-box-orient:vertical;overflow:hidden;max-width:260px;">
                                        {{ $cagnotte->description }}
                                    </p>
                                @endif
                            </td>

                            {{-- Progression --}}
                            <td style="min-width:140px;">
                                <div class="prog-track" style="width:120px;">
                                    <div class="prog-fill" style="width:{{ $progress }}%;"></div>
                                </div>
                                <span style="font-size:.75rem;font-weight:700;
                                      color:{{ $progress >= 100 ? '#4ade80' : ($progress >= 50 ? '#fb923c' : '#555') }};">
                                    {{ $progress }}%
                                </span>
                            </td>

                            {{-- Collecté --}}
                            <td>
                                <span style="font-weight:700;color:#4ade80;font-size:.8375rem;">
                                    {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }}
                                </span>
                                <span style="font-size:.7rem;color:#2d6a3f;"> FCFA</span>
                            </td>

                            {{-- Objectif --}}
                            <td>
                                <span style="font-weight:600;color:#fb923c;font-size:.8375rem;">
                                    {{ number_format($cagnotte->target_amount, 0, ',', ' ') }}
                                </span>
                                <span style="font-size:.7rem;color:#7c3d12;"> FCFA</span>
                            </td>

                            {{-- Statut --}}
                            <td>
                                <span class="badge {{ $statusClass }}">
                                    <div class="badge-dot"></div>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td style="white-space:nowrap;">
                                @if($cagnotte->published_at)
                                    <span style="font-size:.775rem;color:#3a3a3a;">
                                        {{ \Carbon\Carbon::parse($cagnotte->published_at)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span style="font-size:.775rem;color:#2a2a2a;">—</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="22" height="22" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;font-weight:600;color:#666;margin:0;">Aucune cagnotte pour le moment</p>
                                    <p style="font-size:.775rem;color:#444;margin:0;">Créez votre première campagne.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- No result row (JS) --}}
            <div id="no-result" style="display:none;">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="22" height="22" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <p style="font-size:.875rem;font-weight:600;color:#666;margin:0;">Aucun résultat</p>
                    <p style="font-size:.775rem;color:#444;margin:0;">Essayez un autre filtre ou terme de recherche.</p>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    let activeFilter = 'all';

    function setFilter(filter, btn) {
        activeFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
    }

    function applyFilters() {
        const query  = document.getElementById('search-input').value.toLowerCase().trim();
        const rows   = document.querySelectorAll('#main-table tbody tr[data-status]');
        let visible  = 0;

        rows.forEach(row => {
            const statusMatch = activeFilter === 'all' || row.dataset.status === activeFilter;
            const titleMatch  = !query || row.dataset.title.includes(query);
            const show        = statusMatch && titleMatch;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('visible-count').textContent = visible;
        document.getElementById('no-result').style.display   = visible === 0 ? 'block' : 'none';
    }
</script>

</x-app-layout>