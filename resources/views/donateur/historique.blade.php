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
        width: 32px; height: 32px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .8rem;
    }

    /* ── Section card ── */
    .section-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 16px; overflow: hidden;
    }
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; padding: 1.1rem 1.35rem;
        border-bottom: 1px solid #111; flex-wrap: wrap;
    }

    /* ── Search & filter ── */
    .search-wrap { position: relative; }
    .search-input {
        background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #d0d0d0; border-radius: 9px;
        padding: .42rem .9rem .42rem 2.2rem;
        font-size: .8rem; font-family: 'DM Sans', sans-serif;
        outline: none; width: 200px;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
    .search-input::placeholder { color: #2e2e2e; }
    .search-icon {
        position: absolute; left: .65rem; top: 50%;
        transform: translateY(-50%); pointer-events: none; color: #333;
        transition: color .2s;
    }
    .search-wrap:focus-within .search-icon { color: #f97316; }

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
    .filter-btn.active { color: #f97316; border-color: rgba(249,115,22,.35); background: rgba(249,115,22,.08); }
    .filter-dot { width: 5px; height: 5px; border-radius: 50%; }

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
        padding: .95rem 1.25rem; font-size: .8375rem;
        color: #888; vertical-align: middle;
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 600;
        padding: .2rem .65rem; border-radius: 20px; letter-spacing: .02em;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-success { background: rgba(34,197,94,.1);  color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
    .badge-success .badge-dot { background: #4ade80; box-shadow: 0 0 4px #4ade80; }
    .badge-pending { background: rgba(249,115,22,.1); color: #fb923c; border: 1px solid rgba(249,115,22,.2); }
    .badge-pending .badge-dot { background: #fb923c; }
    .badge-failed  { background: rgba(220,38,38,.1);  color: #f87171; border: 1px solid rgba(220,38,38,.2); }
    .badge-failed  .badge-dot { background: #f87171; }

    /* ── Cagnotte chip ── */
    .cagnotte-chip {
        display: inline-flex; align-items: center; gap: .45rem;
    }
    .cagnotte-icon {
        width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
        background: linear-gradient(135deg, rgba(220,38,38,.12), rgba(249,115,22,.1));
        border: 1px solid rgba(249,115,22,.15);
        display: flex; align-items: center; justify-content: center;
    }

    /* ── Empty state ── */
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

    /* ── Pagination ── */
    .pagination-wrap nav { display: flex; justify-content: center; }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr 1fr !important; }
        .search-input { width: 100%; }
        .data-table thead th:nth-child(3),
        .data-table tbody td:nth-child(3) { display: none; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr !important; }
    }
</style>

<div class="page" style="max-width:1100px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.5rem;">

    {{-- ══ HEADER ══ --}}
    <div class="fu" style="display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <div>
            <p class="section-label" style="margin-bottom:.4rem;">Donateur</p>
            <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
                Historique des dons
            </h1>
        </div>
        <a href="{{ route('donateur.feed') }}"
           style="display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;font-weight:500;color:#444;text-decoration:none;transition:color .2s;"
           onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#444'">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
            </svg>
            Voir les cagnottes
        </a>
    </div>

    {{-- ══ STATS ══ --}}
    @php
        $totalDons      = $dons->total();
        $totalMontant   = $dons->getCollection()->where('paiement.status', 'success')->sum('montant');
        $successCount   = $dons->getCollection()->filter(fn($d) => $d->paiement?->status === 'success')->count();
        $pendingCount   = $dons->getCollection()->filter(fn($d) => $d->paiement?->status === 'pending')->count();
    @endphp

    <div class="stats-grid fu-2" style="display:grid;gap:1rem;grid-template-columns:repeat(3,1fr);">

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#dc2626,#f97316);"></div>
            <div class="stat-icon" style="background:rgba(220,38,38,.1);">
                <svg width="14" height="14" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .3rem;">Total dons</p>
            <p class="dash-title" style="font-size:2rem;font-weight:800;color:#f0f0f0;margin:0;line-height:1;">
                {{ $dons->total() }}
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#16a34a,#4ade80);"></div>
            <div class="stat-icon" style="background:rgba(34,197,94,.08);">
                <svg width="14" height="14" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .3rem;">Montant total donné</p>
            <p class="dash-title" style="font-size:1.6rem;font-weight:800;color:#4ade80;margin:0;line-height:1;">
                {{ number_format($totalMontant, 0, ',', ' ') }}
                <span style="font-size:.85rem;font-weight:600;color:#2d6a3f;">XOF</span>
            </p>
        </div>

        <div class="stat-card">
            <div class="stat-accent" style="background:linear-gradient(180deg,#f97316,#fbbf24);"></div>
            <div class="stat-icon" style="background:rgba(249,115,22,.08);">
                <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="section-label" style="margin:0 0 .3rem;">Dons confirmés</p>
            <div style="display:flex;align-items:baseline;gap:.5rem;">
                <p class="dash-title" style="font-size:2rem;font-weight:800;color:#fb923c;margin:0;line-height:1;">
                    {{ $successCount }}
                </p>
                @if($pendingCount > 0)
                    <span style="font-size:.75rem;color:#555;font-weight:500;">
                        + {{ $pendingCount }} en attente
                    </span>
                @endif
            </div>
        </div>

    </div>

    {{-- ══ TABLE ══ --}}
    <div class="section-card fu-3">

        <div class="section-header">
            <div style="display:flex;align-items:center;gap:.65rem;">
                <h2 class="dash-title" style="font-size:.975rem;font-weight:700;color:#e0e0e0;margin:0;">
                    Tous les dons
                </h2>
                <span class="count-chip" id="visible-count">{{ $dons->count() }}</span>
            </div>

            <div style="display:flex;align-items:center;gap:.65rem;flex-wrap:wrap;">
                {{-- Search --}}
                <div class="search-wrap">
                    <svg class="search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text" class="search-input" id="search-input"
                           placeholder="Rechercher…" oninput="applyFilters()" />
                </div>

                {{-- Status filters --}}
                <div style="display:flex;align-items:center;gap:.4rem;">
                    <button class="filter-btn active" data-filter="all" onclick="setFilter('all',this)">Tous</button>
                    <button class="filter-btn" data-filter="success" onclick="setFilter('success',this)">
                        <span class="filter-dot" style="background:#4ade80;"></span> Payés
                    </button>
                    <button class="filter-btn" data-filter="pending" onclick="setFilter('pending',this)">
                        <span class="filter-dot" style="background:#fb923c;"></span> En attente
                    </button>
                    <button class="filter-btn" data-filter="failed" onclick="setFilter('failed',this)">
                        <span class="filter-dot" style="background:#f87171;"></span> Échec
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
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dons as $don)
                        @php
                            $status = $don->paiement?->status ?? 'failed';
                            $badgeClass = match($status) {
                                'success' => 'badge-success',
                                'pending' => 'badge-pending',
                                default   => 'badge-failed',
                            };
                            $badgeLabel = match($status) {
                                'success' => 'Payé',
                                'pending' => 'En attente',
                                default   => 'Échec',
                            };
                        @endphp
                        <tr data-status="{{ $status }}"
                            data-title="{{ strtolower($don->cagnotte->title) }}">

                            {{-- Cagnotte --}}
                            <td>
                                <div class="cagnotte-chip">
                                    <div class="cagnotte-icon">
                                        <svg width="13" height="13" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>
                                    </div>
                                    <span style="font-weight:600;color:#d0d0d0;font-size:.8375rem;">
                                        {{ $don->cagnotte->title }}
                                    </span>
                                </div>
                            </td>

                            {{-- Montant --}}
                            <td>
                                <span style="font-weight:700;color:#4ade80;font-size:.875rem;">
                                    {{ number_format($don->montant, 0, ',', ' ') }}
                                </span>
                                <span style="font-size:.7rem;color:#2d6a3f;font-weight:500;"> XOF</span>
                            </td>

                            {{-- Date --}}
                            <td style="white-space:nowrap;">
                                <p style="font-size:.8125rem;color:#666;margin:0 0 .1rem;">
                                    {{ $don->created_at->format('d/m/Y') }}
                                </p>
                                <p style="font-size:.75rem;color:#333;margin:0;">
                                    {{ $don->created_at->format('H:i') }}
                                </p>
                            </td>

                            {{-- Statut --}}
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    <div class="badge-dot"></div>
                                    {{ $badgeLabel }}
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="22" height="22" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;font-weight:600;color:#666;margin:0;">Aucun don effectué pour le moment</p>
                                    <p style="font-size:.775rem;color:#3a3a3a;margin:0;line-height:1.55;">
                                        Découvrez les cagnottes disponibles et faites votre premier don.
                                    </p>
                                    <a href="{{ route('donateur.feed') }}"
                                       style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.5rem;
                                              padding:.6rem 1.1rem;border-radius:9px;border:none;
                                              background:linear-gradient(135deg,#dc2626,#f97316);
                                              color:#fff;font-size:.8rem;font-weight:600;
                                              font-family:'DM Sans',sans-serif;text-decoration:none;
                                              box-shadow:0 3px 12px rgba(220,38,38,.25);">
                                        Voir les cagnottes
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- No result (JS) --}}
            <div id="no-result" style="display:none;">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="22" height="22" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <p style="font-size:.875rem;font-weight:600;color:#666;margin:0;">Aucun résultat</p>
                    <p style="font-size:.775rem;color:#3a3a3a;margin:0;">Essayez un autre filtre ou terme de recherche.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ══ PAGINATION ══ --}}
    @if($dons->hasPages())
        <div class="pagination-wrap fu-3">
            {{ $dons->links() }}
        </div>
    @endif

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


