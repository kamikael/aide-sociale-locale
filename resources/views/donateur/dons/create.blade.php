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

    /* ── Section card ── */
    .section-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px; overflow: hidden;
    }
    .section-header {
        padding: 1.1rem 1.5rem; border-bottom: 1px solid #111;
        display: flex; align-items: center; gap: .85rem;
    }
    .section-body { padding: 1.5rem; }

    /* ── Labels ── */
    .f-label {
        display: block; font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .1em;
        color: #555; margin-bottom: .5rem;
    }

    /* ── Inputs ── */
    .f-input {
        width: 100%; background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #e0e0e0; border-radius: 11px;
        padding: .75rem 1rem .75rem 2.6rem;
        font-size: .875rem; font-family: 'DM Sans', sans-serif;
        outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .f-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
    .f-input::placeholder { color: #2e2e2e; }

    .f-wrap { position: relative; }
    .f-icon {
        position: absolute; left: .85rem; top: 50%;
        transform: translateY(-50%); pointer-events: none;
        color: #333; transition: color .2s;
    }
    .f-wrap:focus-within .f-icon { color: #f97316; }

    /* Input suffix (FCFA) */
    .f-suffix {
        position: absolute; right: 0; top: 0; bottom: 0;
        display: flex; align-items: center; padding: 0 .9rem;
        background: #111; border: 1px solid #1e1e1e; border-left: none;
        border-radius: 0 11px 11px 0;
        font-size: .775rem; font-weight: 600; color: #444; pointer-events: none;
    }
    .f-with-suffix { border-radius: 11px 0 0 11px; padding-left: 2.6rem; }

    /* ── Amount quick picks ── */
    .amount-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .5rem; margin-bottom: .75rem; }
    .amount-pick {
        display: flex; align-items: center; justify-content: center;
        padding: .55rem; border-radius: 9px;
        border: 1px solid #1e1e1e; background: #0a0a0a;
        font-size: .8rem; font-weight: 600; color: #666;
        cursor: pointer; transition: color .2s, border-color .2s, background .2s;
        white-space: nowrap;
    }
    .amount-pick:hover { color: #f97316; border-color: rgba(249,115,22,.35); background: rgba(249,115,22,.06); }
    .amount-pick.selected { color: #f97316; border-color: rgba(249,115,22,.4); background: rgba(249,115,22,.08); }

    /* ── Provider radio cards ── */
    .provider-grid { display: flex; flex-direction: column; gap: .5rem; }
    .provider-card { position: relative; cursor: pointer; }
    .provider-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .provider-inner {
        display: flex; align-items: center; justify-content: space-between;
        padding: .85rem 1rem; border-radius: 11px;
        border: 1.5px solid #1a1a1a; background: #0a0a0a;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .provider-card:hover .provider-inner { border-color: #2a2a2a; background: #0f0f0f; }
    .provider-card input:checked ~ .provider-inner {
        border-color: #f97316; background: rgba(249,115,22,.06);
        box-shadow: 0 0 0 3px rgba(249,115,22,.08);
    }
    .provider-card input:focus ~ .provider-inner { box-shadow: 0 0 0 3px rgba(249,115,22,.18); }
    .provider-left { display: flex; align-items: center; gap: .75rem; }
    .provider-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: #141414; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s;
    }
    .provider-card input:checked ~ .provider-inner .provider-icon {
        background: linear-gradient(135deg, rgba(220,38,38,.15), rgba(249,115,22,.15));
        border-color: rgba(249,115,22,.2);
    }
    .provider-name { font-size: .875rem; font-weight: 600; color: #888; transition: color .2s; }
    .provider-card input:checked ~ .provider-inner .provider-name { color: #f0f0f0; }
    .provider-radio-dot {
        width: 16px; height: 16px; border-radius: 50%;
        border: 1.5px solid #2a2a2a; background: #0a0a0a; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: border-color .2s;
    }
    .provider-card input:checked ~ .provider-inner .provider-radio-dot {
        border-color: #f97316;
    }
    .provider-radio-dot::after {
        content: ''; width: 7px; height: 7px; border-radius: 50%;
        background: #f97316; opacity: 0; transition: opacity .2s;
    }
    .provider-card input:checked ~ .provider-inner .provider-radio-dot::after { opacity: 1; }

    /* ── Sandbox banner ── */
    .sandbox-banner {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: 1rem 1.1rem; border-radius: 12px;
        background: rgba(251,191,36,.06); border: 1px solid rgba(251,191,36,.2);
    }
    .sandbox-banner p { font-size: .8rem; color: #b45309; margin: 0; line-height: 1.6; }
    .sandbox-banner p strong { color: #fbbf24; }
    .sandbox-number {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: .775rem; font-weight: 700;
        padding: .15rem .55rem; border-radius: 6px;
        background: rgba(251,191,36,.12); color: #fbbf24;
        border: 1px solid rgba(251,191,36,.25);
        font-family: 'Syne', monospace;
    }

    /* ── Cagnotte preview strip ── */
    .cagnotte-strip {
        display: flex; align-items: center; gap: .85rem;
        padding: .9rem 1.1rem; border-radius: 12px;
        background: #111; border: 1px solid #161616;
    }
    .cagnotte-strip-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg, rgba(220,38,38,.15), rgba(249,115,22,.12));
        border: 1px solid rgba(249,115,22,.2);
        display: flex; align-items: center; justify-content: center;
    }

    /* ── Progress (cagnotte) ── */
    .prog-track { height: 3px; border-radius: 4px; background: #1a1a1a; overflow: hidden; }
    .prog-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #dc2626, #f97316); }

    /* ── Amount preview ── */
    .amount-preview {
        display: none; align-items: center; gap: .5rem;
        margin-top: .55rem; padding: .6rem .85rem;
        border-radius: 9px; background: rgba(249,115,22,.06);
        border: 1px solid rgba(249,115,22,.15);
    }
    .amount-preview.visible { display: flex; }

    /* ── Buttons ── */
    .btn-primary {
        display: flex; align-items: center; justify-content: center; gap: .45rem;
        width: 100%; padding: .85rem; border-radius: 11px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .9rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 4px 18px rgba(220,38,38,.3);
        transition: filter .2s, transform .15s, box-shadow .2s;
    }
    .btn-primary:hover { filter: brightness(1.08); transform: translateY(-1px); box-shadow: 0 6px 24px rgba(220,38,38,.4); }
    .btn-primary:active { transform: translateY(0); }
    .btn-primary .arrow { transition: transform .2s; }
    .btn-primary:hover .arrow { transform: translateX(4px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .75rem 1.1rem; border-radius: 11px;
        border: 1px solid #1e1e1e; background: transparent;
        color: #666; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 500; cursor: pointer;
        text-decoration: none; transition: color .2s, border-color .2s, background .2s;
    }
    .btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }

    /* ── Secure note ── */
    .secure-note {
        display: flex; align-items: center; justify-content: center;
        gap: .45rem; margin-top: .75rem;
        font-size: .75rem; color: #2e2e2e;
    }

    /* ── Error ── */
    .f-error { font-size: .775rem; color: #fca5a5; margin-top: .35rem; }

    /* ── Section label ── */
    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    @media (max-width: 480px) {
        .amount-grid { grid-template-columns: repeat(2,1fr); }
        .section-body { padding: 1.1rem; }
    }
</style>

<div class="page" style="max-width:520px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.25rem;">

    {{-- ── Header ── --}}
    <div class="fu">
        <a href="{{ url()->previous() }}"
           style="display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;font-weight:500;color:#444;text-decoration:none;margin-bottom:.9rem;transition:color .2s;"
           onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#444'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Retour
        </a>
        <p class="section-label" style="margin-bottom:.4rem;">Donateur</p>
        <h1 class="dash-title" style="font-size:1.4rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
            Faire un don
        </h1>
    </div>

    {{-- ── Cagnotte preview ── --}}
    @php
        $progress = $cagnotte->target_amount > 0
            ? min(100, round(($cagnotte->collected_amount / $cagnotte->target_amount) * 100))
            : 0;
    @endphp
    <div class="cagnotte-strip fu">
        <div class="cagnotte-strip-icon">
            <svg width="16" height="16" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
            </svg>
        </div>
        <div style="flex:1;min-width:0;">
            <p style="font-size:.8375rem;font-weight:700;color:#d0d0d0;margin:0 0 .3rem;
                      white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $cagnotte->title }}
            </p>
            <div class="prog-track">
                <div class="prog-fill" style="width:{{ $progress }}%;"></div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:.3rem;">
                <span style="font-size:.7rem;color:#4ade80;font-weight:600;">
                    {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }} XOF collectés
                </span>
                <span style="font-size:.7rem;color:#3a3a3a;font-weight:500;">
                    {{ $progress }}%
                </span>
            </div>
        </div>
    </div>

    {{-- ── Sandbox banner ── --}}
    @if(config('services.fedapay.environment') === 'sandbox')
        <div class="sandbox-banner fu">
            <svg width="16" height="16" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21a48.25 48.25 0 01-8.135-.687c-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
            </svg>
            <div>
                <p style="font-weight:700;color:#fbbf24;margin:0 0 .35rem;font-size:.8rem;">
                    Mode test FedaPay actif
                </p>
                <p>
                    Sur la page FedaPay, utilisez <span class="sandbox-number">64000001</span> (MOOV)
                    ou <span class="sandbox-number">66000001</span> (MTN) pour simuler un paiement <strong>réussi</strong>.
                    Tout autre numéro simule un <strong>refus</strong>.
                </p>
            </div>
        </div>
    @endif

    {{-- ── Form ── --}}
    <form action="{{ route('donateur.dons.store', $cagnotte->id) }}" method="POST"
          style="display:flex;flex-direction:column;gap:1.1rem;">
        @csrf

        {{-- BLOC 1 : Montant --}}
        <div class="section-card fu-2">
            <div class="section-header">
                <div style="width:30px;height:30px;border-radius:8px;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="13" height="13" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75"/>
                    </svg>
                </div>
                <div>
                    <h2 class="dash-title" style="font-size:.875rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Montant du don</h2>
                    <p style="font-size:.75rem;color:#444;margin:0;">Minimum 1 000 FCFA</p>
                </div>
            </div>
            <div class="section-body">

                {{-- Quick picks --}}
                <div class="amount-grid" id="quick-picks">
                    @foreach([1000, 2500, 5000, 10000, 25000, 50000] as $preset)
                        <button type="button" class="amount-pick"
                                onclick="setAmount({{ $preset }})">
                            {{ number_format($preset, 0, ',', ' ') }}
                        </button>
                    @endforeach
                </div>

                {{-- Custom input --}}
                <label class="f-label">Ou saisir un montant</label>
                <div class="f-wrap" style="position:relative;">
                    <svg class="f-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <input type="number" name="montant" id="montant-input"
                           min="1000" step="100"
                           placeholder="Ex : 5 000"
                           class="f-input f-with-suffix"
                           oninput="onAmountInput(this.value)"
                           required />
                    <span class="f-suffix">FCFA</span>
                </div>

                {{-- Amount preview --}}
                <div class="amount-preview" id="amount-preview">
                    <svg width="13" height="13" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="preview-text" style="font-size:.8rem;font-weight:600;color:#f97316;"></span>
                </div>

                @error('montant')
                    <p class="f-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- BLOC 2 : Opérateur --}}
        <div class="section-card fu-2">
            <div class="section-header">
                <div style="width:30px;height:30px;border-radius:8px;background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="13" height="13" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3m-3 3.75h3"/>
                    </svg>
                </div>
                <div>
                    <h2 class="dash-title" style="font-size:.875rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">Opérateur Mobile Money</h2>
                    <p style="font-size:.75rem;color:#444;margin:0;">Sélectionnez votre réseau</p>
                </div>
            </div>
            <div class="section-body" style="display:flex;flex-direction:column;gap:1.1rem;">

                {{-- Provider cards --}}
                <div>
                    <label class="f-label">Choisir l'opérateur</label>
                    <div class="provider-grid">
                        @foreach($providers as $provider)
                            <label class="provider-card">
                                <input type="radio" name="provider_id"
                                       value="{{ $provider->id }}" required />
                                <div class="provider-inner">
                                    <div class="provider-left">
                                        <div class="provider-icon">
                                            <svg width="15" height="15" fill="none" stroke="#555" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3"/>
                                            </svg>
                                        </div>
                                        <span class="provider-name">{{ $provider->name }}</span>
                                    </div>
                                    <div class="provider-radio-dot"></div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('provider_id')
                        <p class="f-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone number --}}
                <div>
                    <label for="phone_number" class="f-label">Numéro Mobile Money</label>
                    <div class="f-wrap">
                        <svg class="f-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                        <input type="text" id="phone_number" name="phone_number"
                               required placeholder="+229XXXXXXXX"
                               class="f-input"
                               oninput="formatPhone(this)" />
                    </div>
                    <p style="font-size:.75rem;color:#3a3a3a;margin-top:.4rem;">
                        Format international requis — ex : +229 64 00 00 01
                    </p>
                    @error('phone_number')
                        <p class="f-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── CTA ── --}}
        <div class="fu-3" style="display:flex;flex-direction:column;gap:.5rem;">
            <button type="submit" class="btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
                <span>Continuer vers le paiement</span>
                <svg class="arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </button>

            <a href="{{ url()->previous() }}" class="btn-ghost" style="justify-content:center;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Annuler
            </a>

            <div class="secure-note">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
                Paiement sécurisé via FedaPay
            </div>
        </div>

    </form>
</div>

<script>
/* ── Quick pick amount ── */
function setAmount(val) {
    const input = document.getElementById('montant-input');
    input.value = val;
    onAmountInput(val);
    document.querySelectorAll('.amount-pick').forEach(b => {
        b.classList.toggle('selected', parseInt(b.textContent.replace(/\s/g,'').replace(',','.')) === val
            || b.textContent.trim().replace(/\s/g,'') === val.toLocaleString('fr-FR').replace(',','.'));
    });
    // simpler: match by data
    document.querySelectorAll('.amount-pick').forEach(b => b.classList.remove('selected'));
    // find by onclick value
    document.querySelectorAll('.amount-pick').forEach(b => {
        const match = b.getAttribute('onclick').match(/setAmount\((\d+)\)/);
        if (match && parseInt(match[1]) === val) b.classList.add('selected');
    });
}

function onAmountInput(val) {
    const preview = document.getElementById('amount-preview');
    const text    = document.getElementById('preview-text');
    document.querySelectorAll('.amount-pick').forEach(b => b.classList.remove('selected'));
    if (val && !isNaN(val) && parseInt(val) >= 1000) {
        text.textContent = 'Don de ' + parseInt(val).toLocaleString('fr-FR') + ' FCFA';
        preview.classList.add('visible');
        // highlight matching quick pick
        document.querySelectorAll('.amount-pick').forEach(b => {
            const match = b.getAttribute('onclick').match(/setAmount\((\d+)\)/);
            if (match && parseInt(match[1]) === parseInt(val)) b.classList.add('selected');
        });
    } else {
        preview.classList.remove('visible');
    }
}

/* ── Phone formatting ── */
function formatPhone(input) {
    let val = input.value.replace(/[^\d+]/g, '');
    if (val && !val.startsWith('+')) val = '+' + val;
    input.value = val;
}
</script>

</x-app-layout>
