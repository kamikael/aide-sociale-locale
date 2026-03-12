<x-app-layout>

<style>
    *, *::before, *::after { box-sizing: border-box; }
    .page { font-family: 'DM Sans', sans-serif; }
    .dash-title { font-family: 'Syne', sans-serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(.7); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes spin-slow {
        to { transform: rotate(360deg); }
    }
    @keyframes shimmer { to { background-position: -200% 0; } }
    @keyframes pulse-ring {
        0%   { transform: scale(.9); opacity: .7; }
        100% { transform: scale(1.6); opacity: 0; }
    }

    .fu   { animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .45s .1s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .45s .2s cubic-bezier(.22,1,.36,1) both; }
    .icon-in { animation: scaleIn .5s .05s cubic-bezier(.34,1.56,.64,1) both; }

    .status-icon-wrap {
        position: relative; width: 80px; height: 80px; margin: 0 auto 1.5rem;
        display: flex; align-items: center; justify-content: center;
    }
    .pulse-ring {
        position: absolute; inset: 0; border-radius: 50%;
        border: 2px solid rgba(251,191,36,.4);
        animation: pulse-ring 1.8s ease-out infinite;
    }
    .pulse-ring-2 {
        position: absolute; inset: 0; border-radius: 50%;
        border: 2px solid rgba(251,191,36,.25);
        animation: pulse-ring 1.8s .6s ease-out infinite;
    }
    .status-icon-circle {
        position: relative; z-index: 1;
        width: 72px; height: 72px; border-radius: 50%;
        background: linear-gradient(135deg, rgba(251,191,36,.18), rgba(249,115,22,.12));
        border: 1.5px solid rgba(251,191,36,.35);
        display: flex; align-items: center; justify-content: center;
    }
    .spin-icon { animation: spin-slow 2s linear infinite; }

    .payment-card {
        background: #0d0d0d; border: 1px solid #201a08;
        border-radius: 22px; overflow: hidden;
        max-width: 480px; margin: 0 auto;
    }

    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* Step tracker */
    .step-row {
        display: flex; align-items: center; gap: .65rem;
        padding: .6rem .85rem; border-radius: 10px;
    }
    .step-dot {
        width: 22px; height: 22px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: 800;
    }

    .btn-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
        width: 100%; padding: .8rem; border-radius: 11px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 700; text-decoration: none;
        box-shadow: 0 4px 16px rgba(220,38,38,.28);
        transition: filter .2s, transform .15s;
    }
    .btn-primary:hover { filter: brightness(1.08); transform: translateY(-1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; justify-content: center; gap: .45rem;
        width: 100%; padding: .75rem; border-radius: 11px;
        border: 1px solid #1e1e1e; background: transparent;
        color: #666; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 500; text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
    }
    .btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }
</style>

<div class="page" style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.25rem;">

    <div style="width:100%;max-width:480px;">

        <div class="payment-card fu">
            <div style="height:3px;background:linear-gradient(90deg,#f97316,#fbbf24,#f97316);background-size:200% 100%;animation:shimmer 1.8s linear infinite;"></div>

            <div style="padding:2.5rem 2rem 2rem;text-align:center;">

                {{-- Spinning icon --}}
                <div class="status-icon-wrap icon-in">
                    <div class="pulse-ring"></div>
                    <div class="pulse-ring-2"></div>
                    <div class="status-icon-circle">
                        <svg class="spin-icon" width="30" height="30" fill="none" stroke="#fbbf24" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                    </div>
                </div>

                {{-- Title --}}
                <p class="section-label fu-2" style="margin-bottom:.5rem;">Paiement</p>
                <h1 class="dash-title fu-2" style="font-size:1.45rem;font-weight:800;color:#fbbf24;margin:0 0 .75rem;letter-spacing:-.02em;">
                    Traitement en cours…
                </h1>
                <p class="fu-2" style="font-size:.875rem;color:#666;margin:0 0 1.75rem;line-height:1.65;">
                    Votre demande a bien été prise en compte. Le statut définitif sera mis à jour par l'opérateur dans quelques instants.
                </p>

                {{-- Step tracker --}}
                <div class="fu-2" style="display:flex;flex-direction:column;gap:.4rem;margin-bottom:1.75rem;text-align:left;
                    background:#0a0a0a;border:1px solid #141414;border-radius:13px;padding:.85rem;">
                    <p class="section-label" style="margin-bottom:.4rem;padding:0 .1rem;">Étapes de traitement</p>

                    <div class="step-row" style="background:rgba(34,197,94,.05);">
                        <div class="step-dot" style="background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.25);">
                            <svg width="10" height="10" fill="none" stroke="#4ade80" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.8rem;font-weight:600;color:#4ade80;margin:0;">Demande envoyée</p>
                            <p style="font-size:.72rem;color:#2d6a3f;margin:0;">Votre don a été initié avec succès</p>
                        </div>
                    </div>

                    <div class="step-row" style="background:rgba(251,191,36,.04);">
                        <div class="step-dot" style="background:rgba(251,191,36,.12);border:1px solid rgba(251,191,36,.25);">
                            <svg class="spin-icon" width="10" height="10" fill="none" stroke="#fbbf24" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.8rem;font-weight:600;color:#fbbf24;margin:0;">Confirmation opérateur</p>
                            <p style="font-size:.72rem;color:#7c5a00;margin:0;">En attente de réponse Mobile Money</p>
                        </div>
                    </div>

                    <div class="step-row">
                        <div class="step-dot" style="background:#111;border:1px solid #1e1e1e;">
                            <svg width="10" height="10" fill="none" stroke="#333" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.8rem;font-weight:500;color:#444;margin:0;">Don crédité à la cagnotte</p>
                            <p style="font-size:.72rem;color:#333;margin:0;">En attente de confirmation</p>
                        </div>
                    </div>
                </div>

                {{-- CTAs --}}
                <div class="fu-3" style="display:flex;flex-direction:column;gap:.6rem;">
                    <a href="{{ route('donateur.historique') }}" class="btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Voir mon historique de dons
                    </a>
                    <a href="{{ route('donateur.feed') }}" class="btn-ghost">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                        Retour aux cagnottes
                    </a>
                </div>

                {{-- Secure note --}}
                <div class="fu-3" style="display:flex;align-items:center;justify-content:center;gap:.4rem;margin-top:1.5rem;">
                    <svg width="11" height="11" fill="none" stroke="#2e2e2e" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    <span style="font-size:.72rem;color:#2e2e2e;">Transaction sécurisée via FedaPay</span>
                </div>

            </div>
        </div>

    </div>
</div>

</x-app-layout>