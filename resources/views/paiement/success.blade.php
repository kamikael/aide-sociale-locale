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
    @keyframes ripple {
        0%   { transform: scale(.8); opacity: .6; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    .fu   { animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .45s .1s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .45s .2s cubic-bezier(.22,1,.36,1) both; }
    .icon-in { animation: scaleIn .5s .05s cubic-bezier(.34,1.56,.64,1) both; }

    .status-icon-wrap {
        position: relative; width: 80px; height: 80px; margin: 0 auto 1.5rem;
        display: flex; align-items: center; justify-content: center;
    }
    .status-icon-wrap::before, .status-icon-wrap::after {
        content: ''; position: absolute; inset: 0; border-radius: 50%;
        background: rgba(34,197,94,.18);
    }
    .status-icon-wrap::before { animation: ripple 2s ease-out infinite; }
    .status-icon-wrap::after  { animation: ripple 2s .7s ease-out infinite; }
    .status-icon-circle {
        position: relative; z-index: 1;
        width: 72px; height: 72px; border-radius: 50%;
        background: linear-gradient(135deg, rgba(34,197,94,.2), rgba(74,222,128,.15));
        border: 1.5px solid rgba(34,197,94,.35);
        display: flex; align-items: center; justify-content: center;
    }

    .payment-card {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 22px; overflow: hidden;
        max-width: 480px; margin: 0 auto;
        position: relative;
    }
    .card-accent-bar {
        height: 3px; width: 100%;
        background: linear-gradient(90deg, #16a34a, #4ade80, #16a34a);
        background-size: 200% 100%;
        animation: shimmer 2.5s linear infinite;
    }
    @keyframes shimmer { to { background-position: -200% 0; } }

    .card-body { padding: 2.5rem 2rem 2rem; text-align: center; }

    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    .btn-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
        padding: .8rem 1.5rem; border-radius: 11px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 700; text-decoration: none;
        box-shadow: 0 4px 16px rgba(220,38,38,.28);
        transition: filter .2s, transform .15s;
    }
    .btn-primary:hover { filter: brightness(1.08); transform: translateY(-1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; justify-content: center; gap: .45rem;
        padding: .75rem 1.35rem; border-radius: 11px;
        border: 1px solid #1e1e1e; background: transparent;
        color: #666; font-family: 'DM Sans', sans-serif;
        font-size: .875rem; font-weight: 500; text-decoration: none;
        transition: color .2s, border-color .2s, background .2s;
    }
    .btn-ghost:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }

    .stat-pill {
        display: inline-flex; flex-direction: column; align-items: center;
        padding: .75rem 1.25rem; border-radius: 12px;
        background: #0a0a0a; border: 1px solid #141414;
        flex: 1; min-width: 110px;
    }
</style>

<div class="page" style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.25rem;">

    <div style="width:100%;max-width:480px;">

        <div class="payment-card fu">
            <div class="card-accent-bar" style="background:linear-gradient(90deg,#16a34a,#4ade80,#16a34a);background-size:200% 100%;"></div>

            <div class="card-body">

                {{-- Icon --}}
                <div class="status-icon-wrap icon-in">
                    <div class="status-icon-circle">
                        <svg width="32" height="32" fill="none" stroke="#4ade80" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Title --}}
                <p class="section-label fu-2" style="margin-bottom:.5rem;">Paiement</p>
                <h1 class="dash-title fu-2" style="font-size:1.5rem;font-weight:800;color:#4ade80;margin:0 0 .75rem;letter-spacing:-.02em;">
                    Don confirmé !
                </h1>
                <p class="fu-2" style="font-size:.875rem;color:#666;margin:0 0 1.75rem;line-height:1.65;">
                    Votre paiement a bien été reçu et sera immédiatement pris en compte dans la cagnotte. Merci pour votre générosité.
                </p>

                {{-- CTAs --}}
                <div class="fu-3" style="display:flex;flex-direction:column;gap:.6rem;">
                    <a href="{{ route('donateur.feed') }}" class="btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                        Voir les cagnottes
                    </a>
                    <a href="{{ route('donateur.historique') }}" class="btn-ghost">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Mon historique de dons
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