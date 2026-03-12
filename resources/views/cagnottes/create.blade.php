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
        text-decoration: none;
        transition: color .2s;
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
        padding: 1.35rem 1.75rem;
        border-bottom: 1px solid #111;
        display: flex; align-items: center; gap: 1rem;
    }
    .section-body { padding: 1.75rem; }

    /* ── Form label ── */
    .f-label {
        display: block;
        font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .1em;
        color: #555; margin-bottom: .5rem;
    }

    /* ── Text inputs ── */
    .f-input, .f-textarea, .f-select {
        width: 100%;
        background: #0a0a0a;
        border: 1px solid #1e1e1e;
        color: #e0e0e0;
        border-radius: 11px;
        padding: .75rem 1rem;
        font-size: .875rem;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .f-input:focus, .f-textarea:focus, .f-select:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,.1);
    }
    .f-input::placeholder, .f-textarea::placeholder { color: #2e2e2e; }
    .f-textarea { resize: vertical; min-height: 140px; line-height: 1.6; }

    /* Input with icon */
    .f-input-wrap { position: relative; }
    .f-input-icon {
        position: absolute; left: .9rem; top: 50%;
        transform: translateY(-50%);
        pointer-events: none; color: #333;
        transition: color .2s;
    }
    .f-input-wrap:focus-within .f-input-icon { color: #f97316; }
    .f-input-padded { padding-left: 2.65rem; }

    /* Input suffix */
    .f-input-suffix {
        position: absolute; right: 0; top: 0; bottom: 0;
        display: flex; align-items: center; padding: 0 .9rem;
        background: #111; border: 1px solid #1e1e1e;
        border-left: none; border-radius: 0 11px 11px 0;
        font-size: .775rem; font-weight: 600; color: #444;
        pointer-events: none;
    }
    .f-input-with-suffix { border-radius: 11px 0 0 11px; }

    /* ── Char counter ── */
    .char-counter {
        font-size: .75rem; color: #333; text-align: right;
        margin-top: .35rem; transition: color .2s;
    }
    .char-counter.warn { color: #fb923c; }
    .char-counter.over { color: #f87171; }

    /* ── File drop zone ── */
    .file-zone {
        position: relative;
        border: 1.5px dashed #1e1e1e;
        border-radius: 12px;
        background: #0a0a0a;
        padding: 1.75rem 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }
    .file-zone:hover, .file-zone.drag-over {
        border-color: rgba(249,115,22,.45);
        background: rgba(249,115,22,.03);
    }
    .file-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer;
        width: 100%; height: 100%;
    }
    .file-zone-icon {
        width: 42px; height: 42px; border-radius: 11px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto .75rem;
    }

    /* Image preview */
    #img-preview-wrap { display: none; margin-top: .9rem; }
    #img-preview {
        width: 100%; max-height: 200px; object-fit: cover;
        border-radius: 10px; border: 1px solid #1e1e1e;
    }

    /* ── Helper text ── */
    .helper { font-size: .75rem; color: #3a3a3a; margin-top: .4rem; line-height: 1.5; }

    /* ── Error ── */
    .f-error { font-size: .775rem; color: #fca5a5; margin-top: .35rem; }

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

    /* ── Step indicator ── */
    .step-bar {
        display: flex; align-items: center; gap: 0;
        margin-bottom: 1.75rem;
    }
    .step {
        display: flex; align-items: center; gap: .5rem;
        font-size: .775rem; font-weight: 600; color: #333;
    }
    .step.active { color: #f97316; }
    .step.done   { color: #4ade80; }
    .step-num {
        width: 24px; height: 24px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
        background: #141414; border: 1.5px solid #222; color: #444;
        flex-shrink: 0;
    }
    .step.active .step-num { background: rgba(249,115,22,.15); border-color: rgba(249,115,22,.4); color: #f97316; }
    .step.done .step-num   { background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.3); color: #4ade80; }
    .step-line {
        flex: 1; height: 1px; background: #141414; margin: 0 .6rem;
        max-width: 48px;
    }

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

    @media (max-width: 640px) {
        .section-body { padding: 1.25rem; }
        .section-header { padding: 1.1rem 1.25rem; }
        .two-col { grid-template-columns: 1fr !important; }
    }
</style>

<div class="page" style="max-width:780px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.25rem;">

    {{-- ── Header ── --}}
    <div class="fu">
        <a href="{{ route('organisateur.dashboard') }}" class="back-link" style="margin-bottom:.9rem;display:inline-flex;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Retour au dashboard
        </a>
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="section-label" style="margin-bottom:.4rem;">Organisateur</p>
                <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
                    Créer une cagnotte
                </h1>
            </div>
            {{-- Step indicator --}}
            <div class="step-bar">
                <div class="step active">
                    <div class="step-num">1</div>
                    <span>Infos</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num">2</div>
                    <span>Médias</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num">3</div>
                    <span>Publication</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Form ── --}}
    <form action="{{ route('organisateur.cagnottes.store') }}" method="POST"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:1.1rem;">
        @csrf

        {{-- ── BLOC 1 : Informations générales ── --}}
        <div class="section-card fu-2">
            <div class="section-header">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="14" height="14" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Informations générales</h2>
                    <p style="font-size:.75rem;color:#444;margin:0;">Titre et description de votre campagne</p>
                </div>
            </div>
            <div class="section-body" style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Titre --}}
                <div>
                    <label for="title" class="f-label">Titre de la cagnotte</label>
                    <div class="f-input-wrap">
                        <svg class="f-input-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/>
                        </svg>
                        <input id="title" name="title" type="text"
                               value="{{ old('title') }}"
                               placeholder="Ex : Aide pour la construction d'une école"
                               class="f-input f-input-padded"
                               maxlength="100"
                               oninput="countChars('title','title-count',100)"
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
                              placeholder="Décrivez votre projet, son impact, pourquoi vous avez besoin de soutien…"
                              class="f-textarea"
                              maxlength="2000"
                              oninput="countChars('description','desc-count',2000)"
                              required>{{ old('description') }}</textarea>
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
                <div>
                    <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Objectif financier</h2>
                    <p style="font-size:.75rem;color:#444;margin:0;">Montant cible à atteindre pour votre campagne</p>
                </div>
            </div>
            <div class="section-body">
                <div class="two-col" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">
                    <div>
                        <label for="target_amount" class="f-label">Montant cible</label>
                        <div style="position:relative;">
                            <input id="target_amount" name="target_amount" type="number"
                                   min="1" value="{{ old('target_amount') }}"
                                   placeholder="500 000"
                                   class="f-input f-input-with-suffix"
                                   oninput="formatPreview(this.value)"
                                   required />
                            <span class="f-input-suffix">FCFA</span>
                        </div>
                        <p class="helper" id="amount-preview"></p>
                        @error('target_amount')
                            <p class="f-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="tip-box" style="height:100%;align-items:flex-start;">
                            <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                            </svg>
                            <p>Définissez un objectif <strong>réaliste et précis</strong>. Vous pouvez le modifier avant publication.</p>
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
                <div>
                    <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Médias</h2>
                    <p style="font-size:.75rem;color:#444;margin:0;">Image de couverture et lien vidéo (optionnels)</p>
                </div>
            </div>
            <div class="section-body" style="display:flex;flex-direction:column;gap:1.25rem;">

                <div class="two-col" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">

                    {{-- Image --}}
                    <div>
                        <label class="f-label">Image de couverture</label>
                        <div class="file-zone" id="file-zone"
                             ondragover="this.classList.add('drag-over')"
                             ondragleave="this.classList.remove('drag-over')"
                             ondrop="this.classList.remove('drag-over')">
                            <input type="file" id="image" name="image"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   onchange="previewImage(this)" />
                            <div id="file-label">
                                <div class="file-zone-icon">
                                    <svg width="18" height="18" fill="none" stroke="#444" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </div>
                                <p style="font-size:.8rem;font-weight:600;color:#555;margin:0 0 .2rem;">
                                    Glissez ou <span style="color:#f97316;">parcourir</span>
                                </p>
                                <p style="font-size:.75rem;color:#333;margin:0;">JPG, PNG, WEBP — max 5 Mo</p>
                            </div>
                        </div>
                        <div id="img-preview-wrap">
                            <img id="img-preview" src="" alt="Aperçu" />
                            <button type="button" onclick="removeImage()"
                                    style="display:flex;align-items:center;gap:.35rem;margin-top:.5rem;background:none;border:none;cursor:pointer;font-size:.775rem;color:#555;font-family:'DM Sans',sans-serif;padding:0;transition:color .2s;"
                                    onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='#555'">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Supprimer l'image
                            </button>
                        </div>
                        @error('image')
                            <p class="f-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Vidéo --}}
                    <div>
                        <label for="video_url" class="f-label">Lien vidéo <span style="color:#2a2a2a;font-weight:400;text-transform:none;letter-spacing:0;">(optionnel)</span></label>
                        <div class="f-input-wrap">
                            <svg class="f-input-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/>
                            </svg>
                            <input id="video_url" name="video_url" type="url"
                                   value="{{ old('video_url') }}"
                                   placeholder="https://youtube.com/watch?v=…"
                                   class="f-input f-input-padded" />
                        </div>
                        <p class="helper">YouTube, Vimeo ou tout lien vidéo public. Renforce la crédibilité de votre campagne.</p>
                        @error('video_url')
                            <p class="f-error">{{ $message }}</p>
                        @enderror

                        {{-- Tip --}}
                        <div class="tip-box" style="margin-top:1rem;">
                            <svg width="14" height="14" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
                            </svg>
                            <p>Les cagnottes avec une <strong>vidéo</strong> collectent en moyenne <strong>3× plus</strong>.</p>
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
                Enregistrer la cagnotte
            </button>
        </div>

    </form>
</div>

<script>
/* Char counter */
function countChars(inputId, countId, max) {
    const val = document.getElementById(inputId).value.length;
    const el  = document.getElementById(countId);
    el.textContent = val + ' / ' + max;
    el.className = 'char-counter' + (val > max * .9 ? (val >= max ? ' over' : ' warn') : '');
}

/* Amount preview */
function formatPreview(val) {
    const el = document.getElementById('amount-preview');
    if (!val || isNaN(val)) { el.textContent = ''; return; }
    el.textContent = '→ ' + parseInt(val).toLocaleString('fr-FR') + ' FCFA';
    el.style.color = '#f97316';
}

/* Image preview */
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('img-preview').src = e.target.result;
        document.getElementById('img-preview-wrap').style.display = 'block';
        document.getElementById('file-label').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

/* Remove image */
function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('img-preview-wrap').style.display = 'none';
    document.getElementById('file-label').style.display = 'block';
    const zone = document.getElementById('file-zone');
    zone.style.borderColor = '';
    zone.style.background  = '';
}

/* Init char counters on load */
window.addEventListener('DOMContentLoaded', () => {
    countChars('title', 'title-count', 100);
    countChars('description', 'desc-count', 2000);
    const amt = document.getElementById('target_amount').value;
    if (amt) formatPreview(amt);
});
</script>

</x-app-layout>