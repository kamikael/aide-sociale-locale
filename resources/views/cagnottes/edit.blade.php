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

    /* ── Back link ── */
    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .8rem; font-weight: 500; color: #444;
        text-decoration: none; transition: color .2s;
    }
    .back-link:hover { color: #f97316; }

    /* ── Section card ── */
    .section-card {
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 18px;
        overflow: hidden;
    }
    .section-header {
        padding: 1.2rem 1.75rem;
        border-bottom: 1px solid #111;
        display: flex; align-items: center; gap: 1rem;
    }
    .section-body { padding: 1.75rem; }

    /* ── Labels ── */
    .f-label {
        display: block;
        font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .1em;
        color: #555; margin-bottom: .5rem;
    }

    /* ── Inputs ── */
    .f-input, .f-textarea {
        width: 100%;
        background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #e0e0e0; border-radius: 11px;
        padding: .75rem 1rem;
        font-size: .875rem; font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .f-input:focus, .f-textarea:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,.1);
    }
    .f-input::placeholder, .f-textarea::placeholder { color: #2e2e2e; }
    .f-textarea { resize: vertical; min-height: 140px; line-height: 1.6; }

    /* Icon wrap */
    .f-wrap { position: relative; }
    .f-icon {
        position: absolute; left: .9rem; top: 50%;
        transform: translateY(-50%);
        pointer-events: none; color: #333;
        transition: color .2s;
    }
    .f-wrap:focus-within .f-icon { color: #f97316; }
    .f-padded { padding-left: 2.65rem; }

    /* Suffix */
    .f-suffix {
        position: absolute; right: 0; top: 0; bottom: 0;
        display: flex; align-items: center; padding: 0 .9rem;
        background: #111; border: 1px solid #1e1e1e;
        border-left: none; border-radius: 0 11px 11px 0;
        font-size: .775rem; font-weight: 600; color: #444;
        pointer-events: none;
    }
    .f-with-suffix { border-radius: 11px 0 0 11px; }

    /* ── Char counter ── */
    .char-counter {
        font-size: .75rem; color: #333; text-align: right;
        margin-top: .35rem; transition: color .2s;
    }
    .char-counter.warn { color: #fb923c; }
    .char-counter.over { color: #f87171; }

    /* ── Current image ── */
    .img-current {
        position: relative; border-radius: 12px; overflow: hidden;
        border: 1px solid #1e1e1e; background: #0a0a0a;
    }
    .img-current img {
        width: 100%; height: 180px; object-fit: cover;
        display: block;
        transition: filter .3s;
    }
    .img-overlay {
        position: absolute; inset: 0;
        background: rgba(0,0,0,.55);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity .2s;
    }
    .img-current:hover .img-overlay { opacity: 1; }
    .img-overlay span {
        font-size: .75rem; font-weight: 600; color: #fff;
        background: rgba(249,115,22,.8); padding: .35rem .75rem;
        border-radius: 8px;
    }
    .img-badge-current {
        position: absolute; top: .6rem; left: .6rem;
        font-size: 10px; font-weight: 700; letter-spacing: .06em;
        text-transform: uppercase;
        background: rgba(0,0,0,.7); color: #aaa;
        padding: .2rem .55rem; border-radius: 6px;
        border: 1px solid rgba(255,255,255,.08);
        backdrop-filter: blur(4px);
    }

    /* ── File drop zone ── */
    .file-zone {
        position: relative; border: 1.5px dashed #1e1e1e;
        border-radius: 12px; background: #0a0a0a;
        padding: 1.5rem 1.25rem; text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }
    .file-zone:hover, .file-zone.drag-over {
        border-color: rgba(249,115,22,.45);
        background: rgba(249,115,22,.03);
    }
    .file-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .file-zone-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto .65rem;
    }

    /* New image preview */
    #new-preview-wrap { display: none; margin-top: .85rem; }
    #new-preview {
        width: 100%; height: 160px; object-fit: cover;
        border-radius: 10px; border: 1px solid rgba(249,115,22,.3);
    }

    /* ── Change indicator ── */
    .changed-pill {
        display: none;
        font-size: 10px; font-weight: 700; letter-spacing: .06em;
        text-transform: uppercase;
        background: rgba(249,115,22,.1); color: #f97316;
        border: 1px solid rgba(249,115,22,.25);
        padding: .2rem .55rem; border-radius: 6px;
        margin-left: .6rem;
    }

    /* ── Helper / error ── */
    .helper { font-size: .75rem; color: #3a3a3a; margin-top: .4rem; line-height: 1.5; }
    .f-error { font-size: .775rem; color: #fca5a5; margin-top: .35rem; }

    /* ── Diff row (original vs new) ── */
    .diff-label {
        font-size: 10px; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; color: #3a3a3a; margin-bottom: .35rem;
    }

    /* ── Buttons ── */
    .btn-primary {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .75rem 1.4rem; border-radius: 11px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 600; cursor: pointer;
        box-shadow: 0 4px 16px rgba(220,38,38,.28);
        transition: filter .2s, transform .15s, box-shadow .2s;
        text-decoration: none; white-space: nowrap;
    }
    .btn-primary:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 6px 22px rgba(220,38,38,.38); }
    .btn-primary:active { transform: translateY(0); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .75rem 1.2rem; border-radius: 11px;
        border: 1px solid #1e1e1e; background: transparent;
        color: #666; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 500; cursor: pointer;
        text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
    }
    .btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* ── Tip box ── */
    .tip-box {
        background: rgba(249,115,22,.05); border: 1px solid rgba(249,115,22,.15);
        border-radius: 11px; padding: .85rem 1rem;
        display: flex; align-items: flex-start; gap: .65rem;
    }
    .tip-box p { font-size: .775rem; color: #7a4a1e; margin: 0; line-height: 1.55; }
    .tip-box p strong { color: #fb923c; }

    /* ── Edit notice banner ── */
    .edit-notice {
        display: flex; align-items: center; gap: .75rem;
        padding: .85rem 1.1rem; border-radius: 12px;
        background: rgba(249,115,22,.06);
        border: 1px solid rgba(249,115,22,.18);
    }

    @media (max-width: 640px) {
        .section-body { padding: 1.25rem; }
        .section-header { padding: 1rem 1.25rem; }
        .two-col { grid-template-columns: 1fr !important; }
    }
</style>

<div class="page" style="max-width:780px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.25rem;">

    {{-- ── Header ── --}}
    <div class="fu">
        <a href="{{ route('organisateur.cagnottes') }}" class="back-link" style="margin-bottom:.9rem;display:inline-flex;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Retour aux cagnottes
        </a>

        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="section-label" style="margin-bottom:.4rem;">Organisateur</p>
                <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0 0 .35rem;letter-spacing:-.02em;">
                    Modifier la cagnotte
                </h1>
                <p style="font-size:.8rem;color:#444;margin:0;max-width:420px;line-height:1.5;">
                    Campagne : <span style="color:#888;font-weight:500;">{{ $cagnotte->title }}</span>
                </p>
            </div>

            {{-- Status badge --}}
            @php
                $statusClass = match($cagnotte->status) {
                    'active'    => ['bg:rgba(34,197,94,.1)','color:#4ade80','border:rgba(34,197,94,.2)', 'Active'],
                    'closed'    => ['bg:rgba(100,100,100,.1)','color:#888','border:#222', 'Clôturée'],
                    'suspended' => ['bg:rgba(220,38,38,.1)','color:#f87171','border:rgba(220,38,38,.2)', 'Suspendue'],
                    default     => ['bg:rgba(249,115,22,.1)','color:#fb923c','border:rgba(249,115,22,.2)', ucfirst($cagnotte->status)],
                };
                $dotColor = match($cagnotte->status) {
                    'active' => '#4ade80', 'closed' => '#555',
                    'suspended' => '#f87171', default => '#fb923c',
                };
                $statusBg     = str_replace('bg:', '', $statusClass[0]);
                $statusColor  = str_replace('color:', '', $statusClass[1]);
                $statusBorder = str_replace('border:', '', $statusClass[2]);
                $statusLabel  = $statusClass[3];
            @endphp
            <div style="display:inline-flex;align-items:center;gap:.4rem;font-size:11px;font-weight:600;
                        padding:.3rem .8rem;border-radius:20px;
                        background:{{ $statusBg }};color:{{ $statusColor }};border:1px solid {{ $statusBorder }};">
                <div style="width:5px;height:5px;border-radius:50%;background:{{ $dotColor }};flex-shrink:0;"></div>
                {{ $statusLabel }}
            </div>
        </div>
    </div>

    {{-- ── Edit notice ── --}}
    <div class="edit-notice fu">
        <svg width="15" height="15" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
        </svg>
        <p style="font-size:.8rem;color:#a05a20;margin:0;line-height:1.5;">
            Vous modifiez une cagnotte existante. Les changements seront visibles immédiatement après enregistrement.
        </p>
    </div>

    {{-- ── Form ── --}}
    <form action="{{ route('organisateur.cagnottes.update', $cagnotte) }}" method="POST"
          enctype="multipart/form-data"
          id="edit-form"
          style="display:flex;flex-direction:column;gap:1.1rem;">
        @csrf
        @method('PUT')

        {{-- ── BLOC 1 : Informations générales ── --}}
        <div class="section-card fu-2">
            <div class="section-header">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="14" height="14" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                </div>
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;">
                        <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Informations générales</h2>
                        <span class="changed-pill" id="pill-info">Modifié</span>
                    </div>
                    <p style="font-size:.75rem;color:#444;margin:0;">Titre et description de votre campagne</p>
                </div>
            </div>
            <div class="section-body" style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Titre --}}
                <div>
                    <label for="title" class="f-label">Titre de la cagnotte</label>
                    <div class="f-wrap">
                        <svg class="f-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/>
                        </svg>
                        <input id="title" name="title" type="text"
                               value="{{ old('title', $cagnotte->title) }}"
                               placeholder="Titre de votre cagnotte"
                               class="f-input f-padded"
                               maxlength="100"
                               data-original="{{ $cagnotte->title }}"
                               oninput="countChars('title','title-count',100); trackChange(this,'pill-info')"
                               required />
                    </div>
                    <p class="char-counter" id="title-count">0 / 100</p>
                    @error('title')
                        <p class="f-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="f-label">Description</label>
                    <textarea id="description" name="description" rows="6"
                              placeholder="Décrivez votre projet…"
                              class="f-textarea"
                              maxlength="2000"
                              data-original="{{ $cagnotte->description }}"
                              oninput="countChars('description','desc-count',2000); trackChange(this,'pill-info')"
                              required>{{ old('description', $cagnotte->description) }}</textarea>
                    <p class="char-counter" id="desc-count">0 / 2000</p>
                    @error('description')
                        <p class="f-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── BLOC 2 : Objectif financier ── --}}
        <div class="section-card fu-2">
            <div class="section-header">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="14" height="14" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/>
                    </svg>
                </div>
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;">
                        <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Objectif financier</h2>
                        <span class="changed-pill" id="pill-amount">Modifié</span>
                    </div>
                    <p style="font-size:.75rem;color:#444;margin:0;">Montant cible à atteindre</p>
                </div>
            </div>
            <div class="section-body">
                <div class="two-col" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">
                    <div>
                        <label for="target_amount" class="f-label">Montant cible</label>
                        <div style="position:relative;">
                            <input id="target_amount" name="target_amount" type="number"
                                   min="1"
                                   value="{{ old('target_amount', $cagnotte->target_amount) }}"
                                   placeholder="500 000"
                                   class="f-input f-with-suffix"
                                   data-original="{{ $cagnotte->target_amount }}"
                                   oninput="formatPreview(this.value); trackChange(this,'pill-amount')"
                                   required />
                            <span class="f-suffix">FCFA</span>
                        </div>
                        <p class="helper" id="amount-preview"></p>

                        {{-- Collecté actuel --}}
                        <div style="margin-top:.75rem;padding:.65rem .85rem;background:#111;border:1px solid #141414;border-radius:9px;">
                            <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#3a3a3a;margin:0 0 .25rem;">Déjà collecté</p>
                            <p style="font-size:.875rem;font-weight:700;color:#4ade80;margin:0;">
                                {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }}
                                <span style="font-size:.7rem;color:#2d6a3f;font-weight:500;">FCFA</span>
                            </p>
                        </div>

                        @error('target_amount')
                            <p class="f-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        {{-- Progress actuelle --}}
                        @php
                            $progress = $cagnotte->target_amount > 0
                                ? min(100, round(($cagnotte->collected_amount / $cagnotte->target_amount) * 100))
                                : 0;
                        @endphp
                        <div style="padding:.85rem 1rem;background:#111;border:1px solid #141414;border-radius:11px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
                                <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#3a3a3a;margin:0;">Progression actuelle</p>
                                <span style="font-size:.8rem;font-weight:800;color:{{ $progress >= 100 ? '#4ade80' : ($progress >= 50 ? '#fb923c' : '#666') }};">
                                    {{ $progress }}%
                                </span>
                            </div>
                            <div style="height:4px;border-radius:4px;background:#1a1a1a;overflow:hidden;">
                                <div style="height:100%;border-radius:4px;width:{{ $progress }}%;background:linear-gradient(90deg,#dc2626,#f97316);"></div>
                            </div>
                        </div>

                        <div class="tip-box">
                            <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                            <p>Modifier l'objectif <strong>n'efface pas</strong> les dons déjà collectés.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── BLOC 3 : Médias ── --}}
        <div class="section-card fu-3">
            <div class="section-header">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;">
                        <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Médias</h2>
                        <span class="changed-pill" id="pill-media">Modifié</span>
                    </div>
                    <p style="font-size:.75rem;color:#444;margin:0;">Image de couverture et lien vidéo</p>
                </div>
            </div>
            <div class="section-body" style="display:flex;flex-direction:column;gap:1.25rem;">

                <div class="two-col" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">

                    {{-- Image --}}
                    <div style="display:flex;flex-direction:column;gap:.85rem;">
                        {{-- Image actuelle --}}
                        @if($cagnotte->image_path)
                            <div>
                                <p class="diff-label">Image actuelle</p>
                                <div class="img-current">
                                    <span class="img-badge-current">En ligne</span>
                                    <img src="{{ asset('storage/' . $cagnotte->image_path) }}"
                                         alt="{{ $cagnotte->title }}" />
                                    <div class="img-overlay">
                                        <span>Remplacer ci-dessous</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Upload nouvelle image --}}
                        <div>
                            <p class="diff-label">{{ $cagnotte->image_path ? 'Nouvelle image (optionnel)' : 'Image de couverture' }}</p>
                            <div class="file-zone" id="file-zone"
                                 ondragover="this.classList.add('drag-over')"
                                 ondragleave="this.classList.remove('drag-over')"
                                 ondrop="this.classList.remove('drag-over')">
                                <input type="file" id="image" name="image"
                                       accept=".jpg,.jpeg,.png,.webp"
                                       onchange="previewNewImage(this)" />
                                <div id="file-label">
                                    <div class="file-zone-icon">
                                        <svg width="16" height="16" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.775rem;font-weight:600;color:#555;margin:0 0 .2rem;">
                                        Glissez ou <span style="color:#f97316;">parcourir</span>
                                    </p>
                                    <p style="font-size:.7rem;color:#333;margin:0;">JPG, PNG, WEBP — max 5 Mo</p>
                                </div>
                            </div>

                            <div id="new-preview-wrap">
                                <p class="diff-label" style="margin-bottom:.4rem;">Aperçu nouvelle image</p>
                                <img id="new-preview" src="" alt="Nouvelle image" />
                                <button type="button" onclick="removeNewImage()"
                                        style="display:flex;align-items:center;gap:.35rem;margin-top:.45rem;background:none;border:none;cursor:pointer;font-size:.775rem;color:#555;font-family:'DM Sans',sans-serif;padding:0;transition:color .2s;"
                                        onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='#555'">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Annuler le remplacement
                                </button>
                            </div>
                        </div>

                        @error('image')
                            <p class="f-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Vidéo --}}
                    <div style="display:flex;flex-direction:column;gap:.85rem;">
                        <div>
                            <label for="video_url" class="f-label">
                                Lien vidéo
                                <span style="color:#2a2a2a;font-weight:400;text-transform:none;letter-spacing:0;">(optionnel)</span>
                            </label>
                            <div class="f-wrap">
                                <svg class="f-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/>
                                </svg>
                                <input id="video_url" name="video_url" type="url"
                                       value="{{ old('video_url', $cagnotte->video_url) }}"
                                       placeholder="https://youtube.com/watch?v=…"
                                       class="f-input f-padded"
                                       data-original="{{ $cagnotte->video_url }}"
                                       oninput="trackChange(this,'pill-media')" />
                            </div>
                            <p class="helper">YouTube, Vimeo ou tout lien vidéo public.</p>
                            @error('video_url')
                                <p class="f-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Vidéo actuelle --}}
                        @if($cagnotte->video_url)
                            <div style="padding:.75rem .9rem;background:#111;border:1px solid #141414;border-radius:10px;">
                                <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#3a3a3a;margin:0 0 .4rem;">Lien actuel</p>
                                <a href="{{ $cagnotte->video_url }}" target="_blank" rel="noopener"
                                   style="font-size:.775rem;color:#f97316;text-decoration:none;word-break:break-all;line-height:1.4;display:flex;align-items:center;gap:.4rem;">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                    </svg>
                                    {{ Str::limit($cagnotte->video_url, 40) }}
                                </a>
                            </div>
                        @endif

                        <div class="tip-box">
                            <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
                            </svg>
                            <p>Les cagnottes avec vidéo collectent en moyenne <strong>3× plus</strong>.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Actions ── --}}
        <div class="fu-3" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding:.25rem 0;">
            <a href="{{ route('organisateur.cagnottes') }}" class="btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Enregistrer les modifications
            </button>
        </div>

    </form>
</div>

<script>
/* ── Char counters ── */
function countChars(id, countId, max) {
    const val = document.getElementById(id).value.length;
    const el  = document.getElementById(countId);
    el.textContent = val + ' / ' + max;
    el.className = 'char-counter' + (val > max * .9 ? (val >= max ? ' over' : ' warn') : '');
}

/* ── Track field changes → show "Modifié" pill ── */
function trackChange(el, pillId) {
    const pill = document.getElementById(pillId);
    if (!pill) return;
    pill.style.display = el.value !== el.dataset.original ? 'inline-flex' : 'none';
}

/* ── Amount preview ── */
function formatPreview(val) {
    const el = document.getElementById('amount-preview');
    if (!val || isNaN(val)) { el.textContent = ''; return; }
    el.textContent = '→ ' + parseInt(val).toLocaleString('fr-FR') + ' FCFA';
    el.style.color = '#f97316';
}

/* ── New image preview ── */
function previewNewImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('new-preview').src = e.target.result;
        document.getElementById('new-preview-wrap').style.display = 'block';
        document.getElementById('file-label').style.display = 'none';
        document.getElementById('pill-media').style.display = 'inline-flex';
    };
    reader.readAsDataURL(input.files[0]);
}

/* ── Remove new image ── */
function removeNewImage() {
    document.getElementById('image').value = '';
    document.getElementById('new-preview-wrap').style.display = 'none';
    document.getElementById('file-label').style.display = 'block';
    document.getElementById('pill-media').style.display = 'none';
}

/* ── Init on load ── */
window.addEventListener('DOMContentLoaded', () => {
    countChars('title', 'title-count', 100);
    countChars('description', 'desc-count', 2000);
    const amt = document.getElementById('target_amount').value;
    if (amt) formatPreview(amt);
});
</script>

</x-app-layout>