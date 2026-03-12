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
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        20%     { transform: translateX(-5px); }
        40%     { transform: translateX(5px); }
        60%     { transform: translateX(-3px); }
        80%     { transform: translateX(3px); }
    }
    .fu   { animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .45s .1s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .45s .2s cubic-bezier(.22,1,.36,1) both; }
    .icon-in { animation: scaleIn .5s .05s cubic-bezier(.34,1.56,.64,1) both, shake .5s .55s ease both; }

    .status-icon-wrap {
        position: relative; width: 80px; height: 80px; margin: 0 auto 1.5rem;
        display: flex; align-items: center; justify-content: center;
    }
    .status-icon-circle {
        position: relative; z-index: 1;
        width: 72px; height: 72px; border-radius: 50%;
        background: linear-gradient(135deg, rgba(220,38,38,.2), rgba(248,113,113,.12));
        border: 1.5px solid rgba(220,38,38,.35);
        display: flex; align-items: center; justify-content: center;
    }

    .payment-card {
        background: #0d0d0d; border: 1px solid #1f1212;
        border-radius: 22px; overflow: hidden;
        max-width: 480px; margin: 0 auto;
    }

    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    .tip-item {
        display: flex; align-items: flex-start; gap: .6rem;
        padding: .7rem .9rem; border-radius: 10px;
        background: #0a0a0a; border: 1px solid #141414;
        font-size: .8rem; color: #555; text-align: left; line-height: 1.55;
    }
    .tip-icon { flex-shrink: 0; margin-top: 1px; }

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
            <div style="height:3px;background:linear-gradient(90deg,#dc2626,#f87171,#dc2626);background-size:200% 100%;animation:shimmer 2.5s linear infinite;"></div>

            <div style="padding:2.5rem 2rem 2rem;text-align:center;">

                {{-- Icon --}}
                <div class="status-icon-wrap icon-in">
                    <div class="status-icon-circle">
                        <svg width="30" height="30" fill="none" stroke="#f87171" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>

                {{-- Title --}}
                <p class="section-label fu-2" style="margin-bottom:.5rem;">Paiement</p>
                <h1 class="dash-title fu-2" style="font-size:1.5rem;font-weight:800;color:#f87171;margin:0 0 .75rem;letter-spacing:-.02em;">
                    Paiement échoué
                </h1>
                <p class="fu-2" style="font-size:.875rem;color:#666;margin:0 0 1.5rem;line-height:1.65;">
                    Le paiement n'a pas pu être finalisé — il a été annulé ou refusé par l'opérateur Mobile Money.
                </p>

                {{-- Tips --}}
                <div class="fu-2" style="display:flex;flex-direction:column;gap:.5rem;margin-bottom:1.75rem;text-align:left;">
                    <p class="section-label" style="margin-bottom:.2rem;">Que faire ?</p>
                    <div class="tip-item">
                        <svg class="tip-icon" width="13" height="13" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3"/>
                        </svg>
                        Vérifiez que le numéro Mobile Money saisi est correct et actif.
                    </div>
                    <div class="tip-item">
                        <svg class="tip-icon" width="13" height="13" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75"/>
                        </svg>
                        Assurez-vous d'avoir un solde suffisant sur votre compte.
                    </div>
                    <div class="tip-item">
                        <svg class="tip-icon" width="13" height="13" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        Réessayez dans quelques minutes si le problème persiste.
                    </div>
                </div>

                {{-- CTAs --}}
                <div class="fu-3" style="display:flex;flex-direction:column;gap:.6rem;">
                    <a href="{{ url()->previous() }}" class="btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        Réessayer le paiement
                    </a>
                    <a href="{{ route('donateur.feed') }}" class="btn-ghost">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                        Retour aux cagnottes
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
@keyframes shimmer { to { background-position: -200% 0; } }
</style>

</x-app-layout>