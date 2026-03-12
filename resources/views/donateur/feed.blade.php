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

    /* ── Filter bar ── */
    .filter-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: .75rem;
        flex-wrap: wrap;
    }

    .f-input {
        background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #d0d0d0; border-radius: 9px;
        padding: .55rem .9rem .55rem 2.3rem;
        font-size: .8375rem; font-family: 'DM Sans', sans-serif;
        outline: none; flex: 1; min-width: 180px;
        transition: border-color .2s, box-shadow .2s;
    }
    .f-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
    .f-input::placeholder { color: #2e2e2e; }

    .f-select {
        background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #888; border-radius: 9px;
        padding: .55rem 2.2rem .55rem .85rem;
        font-size: .8375rem; font-family: 'DM Sans', sans-serif;
        outline: none; appearance: none; cursor: pointer;
        transition: border-color .2s, box-shadow .2s;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .7rem center;
    }
    .f-select:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
    .f-select option { background: #111; color: #d0d0d0; }

    .search-wrap { position: relative; flex: 1; min-width: 180px; }
    .search-icon {
        position: absolute; left: .75rem; top: 50%;
        transform: translateY(-50%); pointer-events: none; color: #333;
        transition: color .2s;
    }
    .search-wrap:focus-within .search-icon { color: #f97316; }

    /* ── Filter tags ── */
    .sort-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem .85rem; border-radius: 8px;
        border: 1px solid #1e1e1e; background: transparent;
        font-family: 'DM Sans', sans-serif; font-size: .775rem;
        font-weight: 500; color: #555; cursor: pointer;
        text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
        white-space: nowrap;
    }
    .sort-btn:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }
    .sort-btn.active {
        color: #f97316; border-color: rgba(249,115,22,.35);
        background: rgba(249,115,22,.08);
    }

    .btn-filter {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .8125rem; font-weight: 600; cursor: pointer;
        box-shadow: 0 3px 12px rgba(220,38,38,.25);
        transition: filter .2s, transform .15s;
        white-space: nowrap;
    }
    .btn-filter:hover { filter: brightness(1.1); transform: translateY(-1px); }
    .btn-filter:active { transform: translateY(0); }

    /* ── Cagnotte card ── */
    .c-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
        display: flex; flex-direction: column;
        transition: border-color .22s, box-shadow .22s, transform .22s;
    }
    .c-card:hover {
        border-color: #2a2a2a;
        box-shadow: 0 10px 36px rgba(0,0,0,.5);
        transform: translateY(-3px);
    }

    /* Image */
    .c-img {
        height: 172px; overflow: hidden;
        background: #0a0a0a; position: relative; flex-shrink: 0;
    }
    .c-img img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .45s ease;
    }
    .c-card:hover .c-img img { transform: scale(1.05); }
    .c-no-img {
        height: 172px; background: #0a0a0a;
        border-bottom: 1px solid #111;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* Progress overlay on image */
    .img-prog {
        position: absolute; bottom: 0; left: 0; right: 0;
        height: 3px; background: rgba(0,0,0,.4);
    }
    .img-prog-fill {
        height: 100%;
        background: linear-gradient(90deg, #dc2626, #f97316);
        transition: width .5s ease;
    }

    /* Card body */
    .c-body {
        padding: 1.1rem 1.25rem 1.25rem;
        display: flex; flex-direction: column; flex: 1; gap: .75rem;
    }

    /* Author chip */
    .author-chip {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .75rem; color: #555; font-weight: 500;
    }
    .author-avatar {
        width: 20px; height: 20px; border-radius: 50%;
        background: linear-gradient(135deg, rgba(220,38,38,.2), rgba(249,115,22,.2));
        border: 1px solid rgba(249,115,22,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 9px; font-weight: 700; color: #f97316;
        flex-shrink: 0; font-family: 'Syne', sans-serif;
    }

    /* Progress section */
    .prog-track {
        height: 3.5px; border-radius: 4px;
        background: #161616; overflow: hidden;
    }
    .prog-fill {
        height: 100%; border-radius: 4px;
        background: linear-gradient(90deg, #dc2626, #f97316);
    }

    /* Stat row */
    .stat-row {
        display: flex; align-items: center; justify-content: space-between;
        gap: .5rem;
    }

    /* CTA buttons */
    .btn-view {
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        padding: .65rem; border-radius: 9px;
        border: 1px solid #1e1e1e; background: #111;
        color: #888; font-family: 'DM Sans', sans-serif;
        font-size: .8rem; font-weight: 500; text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
        flex: 1;
    }
    .btn-view:hover { color: #d0d0d0; border-color: #2a2a2a; background: #161616; }

    .btn-don {
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        padding: .65rem; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .8rem; font-weight: 600; text-decoration: none;
        box-shadow: 0 3px 12px rgba(220,38,38,.25);
        transition: filter .2s, transform .15s, box-shadow .2s;
        flex: 1;
    }
    .btn-don:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 5px 18px rgba(220,38,38,.38); }
    .btn-don:active { transform: translateY(0); }
    .btn-don .arrow { transition: transform .2s; }
    .btn-don:hover .arrow { transform: translateX(3px); }

    /* ── Empty state ── */
    .empty-state {
        grid-column: 1 / -1;
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; text-align: center;
        padding: 4rem 2rem; gap: .75rem;
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 16px;
    }
    .empty-icon {
        width: 54px; height: 54px; border-radius: 14px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .25rem;
    }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* ── Count chip ── */
    .count-chip {
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; min-width: 22px; height: 20px;
        padding: 0 .5rem; border-radius: 20px;
        background: rgba(249,115,22,.1); color: #f97316;
        border: 1px solid rgba(249,115,22,.2);
    }

    /* ── Pagination override ── */
    .pagination-wrap nav { display: flex; justify-content: center; }

    @media (max-width: 640px) {
        .filter-card { flex-direction: column; }
        .f-input, .f-select { width: 100%; }
        .sort-tabs { display: none; }
    }
</style>

<div class="page" style="max-width:1200px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.5rem;">

    {{-- ══ HEADER ══ --}}
    <div class="fu" style="display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <div>
            <p class="section-label" style="margin-bottom:.4rem;">Donateur</p>
            <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
                Cagnottes disponibles
            </h1>
        </div>
        <div style="display:flex;align-items:center;gap:.6rem;">
            <span class="count-chip">{{ $cagnottes->total() }}</span>
            <span style="font-size:.8rem;color:#444;">campagne{{ $cagnottes->total() > 1 ? 's' : '' }} active{{ $cagnottes->total() > 1 ? 's' : '' }}</span>
        </div>
    </div>

    {{-- ══ FILTER BAR ══ --}}
    <form method="GET" class="fu-2">
        <div class="filter-card">

            {{-- Search --}}
            <div class="search-wrap">
                <svg class="search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Rechercher une cagnotte…"
                       class="f-input" />
            </div>

            {{-- Sort tabs (desktop) ── --}}
            <div class="sort-tabs" style="display:flex;align-items:center;gap:.4rem;">
                <a href="?sort=recent{{ request('search') ? '&search='.request('search') : '' }}"
                   class="sort-btn {{ request('sort','recent') === 'recent' ? 'active' : '' }}">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Récentes
                </a>
                <a href="?sort=popular{{ request('search') ? '&search='.request('search') : '' }}"
                   class="sort-btn {{ request('sort') === 'popular' ? 'active' : '' }}">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    Populaires
                </a>
                <a href="?sort=goal{{ request('search') ? '&search='.request('search') : '' }}"
                   class="sort-btn {{ request('sort') === 'goal' ? 'active' : '' }}">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    Objectif élevé
                </a>
            </div>

            {{-- Sort select (mobile fallback) --}}
            <select name="sort" class="f-select" style="display:none;" id="sort-select">
                <option value="recent"  {{ request('sort','recent') === 'recent'  ? 'selected' : '' }}>Plus récentes</option>
                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Plus populaires</option>
                <option value="goal"    {{ request('sort') === 'goal'    ? 'selected' : '' }}>Objectif le plus élevé</option>
            </select>

            <button type="submit" class="btn-filter">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                Rechercher
            </button>

        </div>
    </form>

    {{-- ══ FEED GRID ══ --}}
    <div class="fu-3" style="display:grid;gap:1.1rem;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));">

        @forelse($cagnottes as $cagnotte)
            @php
                $progress = $cagnotte->target_amount > 0
                    ? min(100, round(($cagnotte->collected_amount / $cagnotte->target_amount) * 100))
                    : 0;
                $initial = strtoupper(substr($cagnotte->user->name, 0, 1));
            @endphp

            <div class="c-card">

                {{-- Image / placeholder --}}
                @if($cagnotte->image_path)
                    <div class="c-img">
                        <img src="{{ asset('storage/' . $cagnotte->image_path) }}"
                             alt="{{ $cagnotte->title }}" loading="lazy" />
                        <div class="img-prog">
                            <div class="img-prog-fill" style="width:{{ $progress }}%;"></div>
                        </div>
                    </div>
                @else
                    <div class="c-no-img">
                        <svg width="32" height="32" fill="none" stroke="#1e1e1e" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                @endif

                {{-- Body --}}
                <div class="c-body">

                    {{-- Author --}}
                    <div class="author-chip">
                        <div class="author-avatar">{{ $initial }}</div>
                        <span>{{ $cagnotte->user->name }}</span>
                    </div>

                    {{-- Title --}}
                    <h2 class="dash-title" style="font-size:.975rem;font-weight:700;color:#e0e0e0;margin:0;line-height:1.3;">
                        {{ $cagnotte->title }}
                    </h2>

                    {{-- Description --}}
                    <p style="font-size:.8rem;color:#555;margin:0;line-height:1.6;
                              display:-webkit-box;-webkit-line-clamp:2;
                              -webkit-box-orient:vertical;overflow:hidden;">
                        {{ $cagnotte->description }}
                    </p>

                    {{-- Spacer --}}
                    <div style="flex:1;min-height:.25rem;"></div>

                    {{-- Progress --}}
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.4rem;">
                            <span style="font-size:.75rem;color:#444;font-weight:500;">Progression</span>
                            <span style="font-size:.75rem;font-weight:800;
                                  color:{{ $progress >= 100 ? '#4ade80' : ($progress >= 60 ? '#fb923c' : '#666') }};">
                                {{ $progress }}%
                            </span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" style="width:{{ $progress }}%;"></div>
                        </div>
                    </div>

                    {{-- Amounts --}}
                    <div class="stat-row">
                        <div>
                            <p style="font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#3a3a3a;margin:0 0 .2rem;">Collecté</p>
                            <p style="font-size:.875rem;font-weight:700;color:#4ade80;margin:0;line-height:1;">
                                {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }}
                                <span style="font-size:.7rem;color:#2d6a3f;font-weight:500;">XOF</span>
                            </p>
                        </div>
                        <div style="width:1px;height:28px;background:#141414;"></div>
                        <div style="text-align:right;">
                            <p style="font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#3a3a3a;margin:0 0 .2rem;">Objectif</p>
                            <p style="font-size:.875rem;font-weight:700;color:#fb923c;margin:0;line-height:1;">
                                {{ number_format($cagnotte->target_amount, 0, ',', ' ') }}
                                <span style="font-size:.7rem;color:#7c3d12;font-weight:500;">XOF</span>
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex;gap:.55rem;padding-top:.85rem;border-top:1px solid #111;">
                        <a href="{{ route('cagnottes.show', $cagnotte->slug) }}" class="btn-view">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Voir
                        </a>
                        <a href="{{ route('donateur.dons.create', $cagnotte->id) }}" class="btn-don">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                            Faire un don
                            <svg class="arrow" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="24" height="24" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </div>
                <p style="font-size:.975rem;font-weight:700;color:#666;margin:0;">Aucune cagnotte trouvée</p>
                <p style="font-size:.8rem;color:#3a3a3a;margin:0;line-height:1.55;">
                    @if(request('search'))
                        Aucun résultat pour <span style="color:#f97316;">"{{ request('search') }}"</span> — essayez un autre terme.
                    @else
                        Aucune cagnotte active pour le moment. Revenez bientôt.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('donateur.feed') }}"
                       style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.5rem;
                              font-size:.8rem;color:#f97316;text-decoration:none;font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Effacer la recherche
                    </a>
                @endif
            </div>
        @endforelse

    </div>

    {{-- ══ PAGINATION ══ --}}
    @if($cagnottes->hasPages())
        <div class="pagination-wrap fu-3" style="margin-top:.5rem;">
            {{ $cagnottes->links() }}
        </div>
    @endif

</div>

<script>
/* Responsive: show select on mobile, hide sort tabs */
function handleResize() {
    const tabs   = document.querySelector('.sort-tabs');
    const select = document.getElementById('sort-select');
    if (!tabs || !select) return;
    const isMobile = window.innerWidth < 640;
    tabs.style.display   = isMobile ? 'none' : 'flex';
    select.style.display = isMobile ? 'block' : 'none';
}
handleResize();
window.addEventListener('resize', handleResize);
</script>

</x-app-layout>