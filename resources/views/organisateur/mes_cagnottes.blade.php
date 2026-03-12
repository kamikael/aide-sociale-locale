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
    .fu-2 { animation: fadeUp .4s .06s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .4s .12s cubic-bezier(.22,1,.36,1) both; }

    /* ── Page header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    /* ── Alert ── */
    .alert-success {
        display: flex; align-items: flex-start; gap: .65rem;
        padding: .85rem 1.1rem; margin-bottom: 1.25rem;
        border-radius: 12px;
        background: rgba(34,197,94,.07);
        border: 1px solid rgba(34,197,94,.2);
    }

    /* ── Cagnotte card ── */
    .c-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color .2s, box-shadow .2s, transform .2s;
    }
    .c-card:hover {
        border-color: #2a2a2a;
        box-shadow: 0 8px 32px rgba(0,0,0,.45);
        transform: translateY(-2px);
    }

    /* Image zone */
    .c-card-img {
        position: relative;
        height: 168px;
        overflow: hidden;
        background: #111;
        flex-shrink: 0;
    }
    .c-card-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .c-card:hover .c-card-img img { transform: scale(1.04); }

    /* No image placeholder */
    .c-card-no-img {
        height: 168px;
        background: #0a0a0a;
        border-bottom: 1px solid #141414;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* Status badge overlay */
    .img-badge {
        position: absolute;
        top: .75rem; right: .75rem;
    }

    /* Card body */
    .c-card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: .9rem;
    }

    /* Progress */
    .prog-track {
        height: 4px; border-radius: 4px;
        background: #1a1a1a; overflow: hidden;
    }
    .prog-fill {
        height: 100%; border-radius: 4px;
        background: linear-gradient(90deg, #dc2626, #f97316);
        transition: width .5s ease;
    }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11px; font-weight: 600;
        padding: .2rem .65rem; border-radius: 20px;
        letter-spacing: .02em;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-active    { background: rgba(34,197,94,.1);   color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
    .badge-active    .badge-dot { background: #4ade80; box-shadow: 0 0 4px #4ade80; }
    .badge-closed    { background: rgba(100,100,100,.1); color: #888;    border: 1px solid #222; }
    .badge-closed    .badge-dot { background: #666; }
    .badge-suspended { background: rgba(220,38,38,.1);   color: #f87171; border: 1px solid rgba(220,38,38,.2); }
    .badge-suspended .badge-dot { background: #f87171; }
    .badge-pending   { background: rgba(249,115,22,.1);  color: #fb923c; border: 1px solid rgba(249,115,22,.2); }
    .badge-pending   .badge-dot { background: #fb923c; }

    /* Buttons */
    .btn-primary {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem .95rem; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .8rem; font-weight: 600; cursor: pointer;
        text-decoration: none;
        box-shadow: 0 3px 12px rgba(220,38,38,.25);
        transition: filter .2s, transform .15s, box-shadow .2s;
        white-space: nowrap;
    }
    .btn-primary:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 5px 18px rgba(220,38,38,.38); }
    .btn-primary:active { transform: translateY(0); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem .95rem; border-radius: 9px;
        border: 1px solid #1e1e1e; background: #111;
        color: #777; font-family: 'DM Sans', sans-serif;
        font-size: .8rem; font-weight: 500; cursor: pointer;
        text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
        white-space: nowrap;
    }
    .btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: #161616; }

    .btn-danger {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem .95rem; border-radius: 9px;
        border: 1px solid rgba(220,38,38,.2); background: transparent;
        color: #f87171; font-family: 'DM Sans', sans-serif;
        font-size: .8rem; font-weight: 500; cursor: pointer;
        transition: background .2s, border-color .2s;
        white-space: nowrap;
    }
    .btn-danger:hover { background: rgba(220,38,38,.08); border-color: rgba(220,38,38,.35); }

    /* ── Empty state ── */
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; text-align: center;
        padding: 4rem 2rem; gap: .75rem;
        background: #0d0d0d; border: 1px solid #1a1a1a; border-radius: 16px;
    }
    .empty-icon {
        width: 56px; height: 56px; border-radius: 15px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .25rem;
    }

    /* ── Stat mini row ── */
    .stat-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: .5rem;
    }
    .stat-mini {
        background: #111; border: 1px solid #141414; border-radius: 9px;
        padding: .6rem .8rem;
    }

    /* ── Confirm modal ── */
    .modal-overlay {
        display: none; position: fixed; inset: 0; z-index: 200;
        background: rgba(0,0,0,.75); backdrop-filter: blur(4px);
        align-items: center; justify-content: center; padding: 1rem;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #0e0e0e; border: 1px solid #1e1e1e;
        border-radius: 16px; padding: 1.75rem;
        max-width: 380px; width: 100%;
        box-shadow: 0 24px 64px rgba(0,0,0,.65);
        animation: fadeUp .3s cubic-bezier(.22,1,.36,1);
    }

    /* ── Pagination override ── */
    .pagination-wrap nav { display: flex; justify-content: center; }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700;
        letter-spacing: .14em; text-transform: uppercase;
        color: #444;
    }

    @media (max-width: 640px) {
        .page-header { flex-direction: column; align-items: flex-start; }
    }
</style>

{{-- ── Confirm delete modal ── --}}
<div class="modal-overlay" id="delete-modal" role="dialog" aria-modal="true">
    <div class="modal-box">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.2);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
            <svg width="18" height="18" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
            </svg>
        </div>
        <h3 class="dash-title" style="font-size:1rem;font-weight:700;color:#f0f0f0;margin:0 0 .4rem;">Supprimer cette cagnotte ?</h3>
        <p style="font-size:.8125rem;color:#666;margin:0 0 1.35rem;line-height:1.55;">
            Cette action est irréversible. Toutes les données associées seront définitivement supprimées.
        </p>
        <div style="display:flex;gap:.65rem;justify-content:flex-end;">
            <button onclick="closeModal()" class="btn-ghost">Annuler</button>
            <form id="delete-form" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.3);">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════ PAGE ══════════════ --}}
<div class="page" style="max-width:1200px;margin:0 auto;padding:1.75rem 1.25rem;">

    {{-- Header --}}
    <div class="page-header fu">
        <div>
            <p class="section-label" style="margin-bottom:.4rem;">Organisateur</p>
            <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
                Mes cagnottes
            </h1>
        </div>
        <a href="{{ route('organisateur.cagnottes.create') }}" class="btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Nouvelle cagnotte
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert-success fu">
            <svg width="15" height="15" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:.8375rem;color:#86efac;margin:0;">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Empty --}}
    @if($cagnottes->isEmpty())
        <div class="empty-state fu-2">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </div>
            <p style="font-size:.975rem;font-weight:700;color:#888;margin:0;">Aucune cagnotte pour le moment</p>
            <p style="font-size:.8rem;color:#444;margin:0;line-height:1.55;">Créez votre première campagne et commencez à collecter.</p>
            <a href="{{ route('organisateur.cagnottes.create') }}" class="btn-primary" style="margin-top:.5rem;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Créer ma première cagnotte
            </a>
        </div>

    @else

        {{-- Grid --}}
        <div class="fu-2" style="display:grid;gap:1.1rem;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));">
            @foreach($cagnottes as $cagnotte)
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

                <div class="c-card">

                    {{-- Image --}}
                    @if($cagnotte->image_path)
                        <div class="c-card-img">
                            <img src="{{ asset('storage/' . $cagnotte->image_path) }}"
                                 alt="{{ $cagnotte->title }}" loading="lazy">
                            <div class="img-badge">
                                <span class="badge {{ $statusClass }}">
                                    <div class="badge-dot"></div>
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="c-card-no-img">
                            <svg width="32" height="32" fill="none" stroke="#222" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Body --}}
                    <div class="c-card-body">

                        {{-- Title + badge (si pas d'image) --}}
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                            <h3 class="dash-title" style="font-size:.975rem;font-weight:700;color:#e0e0e0;margin:0;line-height:1.3;flex:1;">
                                {{ $cagnotte->title }}
                            </h3>
                            @if(!$cagnotte->image_path)
                                <span class="badge {{ $statusClass }}" style="flex-shrink:0;">
                                    <div class="badge-dot"></div>{{ $statusLabel }}
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p style="font-size:.8rem;color:#555;margin:0;line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $cagnotte->description }}
                        </p>

                        {{-- Progress --}}
                        <div>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.45rem;">
                                <span style="font-size:.75rem;color:#555;font-weight:500;">Progression</span>
                                <span style="font-size:.75rem;font-weight:700;color:{{ $progress >= 100 ? '#4ade80' : ($progress >= 50 ? '#fb923c' : '#888') }};">
                                    {{ $progress }}%
                                </span>
                            </div>
                            <div class="prog-track">
                                <div class="prog-fill" style="width:{{ $progress }}%;"></div>
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="stat-row">
                            <div class="stat-mini">
                                <p style="font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#444;margin:0 0 .25rem;">Collecté</p>
                                <p style="font-size:.85rem;font-weight:700;color:#4ade80;margin:0;line-height:1.1;">
                                    {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }}
                                    <span style="font-size:.7rem;color:#2d6a3f;font-weight:500;">FCFA</span>
                                </p>
                            </div>
                            <div class="stat-mini">
                                <p style="font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#444;margin:0 0 .25rem;">Objectif</p>
                                <p style="font-size:.85rem;font-weight:700;color:#fb923c;margin:0;line-height:1.1;">
                                    {{ number_format($cagnotte->target_amount, 0, ',', ' ') }}
                                    <span style="font-size:.7rem;color:#7c3d12;font-weight:500;">FCFA</span>
                                </p>
                            </div>
                        </div>

                        {{-- Date --}}
                        @if($cagnotte->published_at)
                            <p style="font-size:.75rem;color:#3a3a3a;margin:0;display:flex;align-items:center;gap:.4rem;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                                Publiée le {{ \Carbon\Carbon::parse($cagnotte->published_at)->format('d/m/Y') }}
                            </p>
                        @endif

                        {{-- Spacer --}}
                        <div style="flex:1;"></div>

                        {{-- Actions --}}
                        <div style="display:flex;gap:.55rem;padding-top:.75rem;border-top:1px solid #111;flex-wrap:wrap;">
                            <a href="{{ route('organisateur.cagnottes.edit', $cagnotte) }}" class="btn-ghost" style="flex:1;justify-content:center;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                </svg>
                                Modifier
                            </a>
                            <button
                                onclick="openModal('{{ route('organisateur.cagnottes.destroy', $cagnotte) }}')"
                                class="btn-danger"
                                style="flex:1;justify-content:center;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Supprimer
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($cagnottes->hasPages())
            <div class="pagination-wrap fu-3" style="margin-top:2rem;">
                {{ $cagnottes->links() }}
            </div>
        @endif

    @endif

</div>

<script>
function openModal(deleteUrl) {
    document.getElementById('delete-form').action = deleteUrl;
    document.getElementById('delete-modal').classList.add('open');
}
function closeModal() {
    document.getElementById('delete-modal').classList.remove('open');
}
// Close on overlay click
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
// Close on Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
</script>

</x-app-layout>

