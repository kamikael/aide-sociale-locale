<x-guest-layout>

<style>
    .login-title { font-family: 'Syne', sans-serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fu-1 { animation: fadeUp .4s .05s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .4s .12s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .4s .20s cubic-bezier(.22,1,.36,1) both; }

    /* ── Inputs ── */
    .f-input {
        width: 100%;
        background: #0a0a0a;
        border: 1px solid #222;
        color: #e8e8e8;
        border-radius: 10px;
        padding: .7rem .9rem .7rem 2.6rem;
        font-size: .875rem;
        font-family: 'DM Sans', sans-serif;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .f-input:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,.1);
    }
    .f-input::placeholder { color: #333; }
    .f-input-pr { padding-right: 2.8rem; }

    /* ── Select ── */
    .f-select {
        width: 100%;
        background: #0a0a0a;
        border: 1px solid #222;
        color: #e8e8e8;
        border-radius: 10px;
        padding: .7rem 2.6rem .7rem 2.6rem;
        font-size: .875rem;
        font-family: 'DM Sans', sans-serif;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        appearance: none;
        cursor: pointer;
    }
    .f-select:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,.1);
    }
    .f-select option {
        background: #111;
        color: #e8e8e8;
    }

    /* ── Role cards ── */
    .role-cards { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem; }
    .role-card {
        position: relative;
        cursor: pointer;
    }
    .role-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0; height: 0;
    }
    .role-card-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .5rem;
        padding: .9rem .75rem;
        border-radius: 11px;
        border: 1.5px solid #1e1e1e;
        background: #0a0a0a;
        transition: border-color .2s, background .2s, box-shadow .2s;
        text-align: center;
    }
    .role-card:hover .role-card-inner {
        border-color: #2e2e2e;
        background: #0f0f0f;
    }
    .role-card input:checked ~ .role-card-inner {
        border-color: #f97316;
        background: rgba(249,115,22,.06);
        box-shadow: 0 0 0 3px rgba(249,115,22,.08);
    }
    .role-card input:focus ~ .role-card-inner {
        box-shadow: 0 0 0 3px rgba(249,115,22,.18);
    }
    .role-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        background: #161616;
        transition: background .2s;
    }
    .role-card input:checked ~ .role-card-inner .role-icon {
        background: linear-gradient(135deg, rgba(220,38,38,.2), rgba(249,115,22,.2));
    }
    .role-card input:checked ~ .role-card-inner .role-icon svg { color: #f97316; }
    .role-icon svg { color: #444; transition: color .2s; }
    .role-label {
        font-size: .8rem;
        font-weight: 600;
        color: #666;
        transition: color .2s;
    }
    .role-card input:checked ~ .role-card-inner .role-label { color: #f97316; }
    .role-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        border: 1.5px solid #2a2a2a;
        transition: background .2s, border-color .2s;
    }
    .role-card input:checked ~ .role-card-inner .role-dot {
        background: #f97316;
        border-color: #f97316;
    }

    /* ── Field icon ── */
    .field-icon {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        width: 15px; height: 15px;
        color: #333;
        pointer-events: none;
        transition: color .2s;
    }
    .field-wrap:focus-within .field-icon { color: #f97316; }

    /* ── Chevron select ── */
    .select-chevron {
        position: absolute;
        right: .85rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #333;
    }

    /* ── Password toggle ── */
    .pw-toggle {
        position: absolute;
        right: .85rem;
        top: 50%;
        transform: translateY(-50%);
        background: none; border: none; padding: 0;
        cursor: pointer;
        color: #333;
        line-height: 0;
        transition: color .2s;
    }
    .pw-toggle:hover { color: #f97316; }

    /* ── Label ── */
    .f-label {
        display: block;
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #555;
        margin-bottom: .45rem;
    }

    /* ── Info banner ── */
    .info-banner {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        padding: .8rem 1rem;
        border-radius: 10px;
        background: rgba(249,115,22,.06);
        border: 1px solid rgba(249,115,22,.18);
        margin-top: 1.1rem;
    }
    .info-banner p {
        font-size: .775rem;
        color: #a8a8a8;
        line-height: 1.55;
        margin: 0;
    }
    .info-banner p strong { color: #f97316; font-weight: 600; }

    /* ── Strength bar ── */
    .strength-bar { display: flex; gap: 3px; margin-top: .45rem; }
    .strength-seg {
        height: 3px;
        flex: 1;
        border-radius: 2px;
        background: #1c1c1c;
        transition: background .3s;
    }

    /* ── CTA ── */
    .btn-cta {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .8rem 1.5rem;
        border-radius: 11px;
        border: none;
        background: linear-gradient(135deg, #dc2626 0%, #ea580c 60%, #f97316 100%);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .875rem;
        font-weight: 600;
        letter-spacing: .02em;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(220,38,38,.3);
        transition: filter .2s, transform .15s, box-shadow .2s;
    }
    .btn-cta:hover {
        filter: brightness(1.08);
        transform: translateY(-1px);
        box-shadow: 0 6px 28px rgba(220,38,38,.42);
    }
    .btn-cta:active { transform: translateY(0); filter: brightness(.97); }
    .btn-cta .arrow { transition: transform .2s; }
    .btn-cta:hover .arrow { transform: translateX(4px); }

    /* ── Link ── */
    .link-o {
        color: #f97316;
        text-decoration: none;
        font-weight: 500;
        font-size: .8125rem;
        position: relative;
        transition: color .2s;
    }
    .link-o::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0;
        width: 0; height: 1px;
        background: #f97316;
        transition: width .22s;
    }
    .link-o:hover { color: #fb923c; }
    .link-o:hover::after { width: 100%; }

    /* ── Divider ── */
    .row-sep {
        height: 1px;
        background: linear-gradient(90deg, transparent, #1a1a1a 30%, #1a1a1a 70%, transparent);
        margin: 1.35rem 0;
    }
</style>

{{-- ── Header ── --}}
<div class="fu-1">
    <div style="height:2px;border-radius:2px;background:linear-gradient(90deg,#dc2626,#f97316,transparent);margin-bottom:1.4rem;"></div>

    <div style="display:flex;align-items:center;gap:.85rem;margin-bottom:.65rem;">
        <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#dc2626,#f97316);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(220,38,38,.35);">
            <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
            </svg>
        </div>
        <div>
            <h1 class="login-title" style="font-size:1.35rem;font-weight:800;color:#f0f0f0;margin:0;line-height:1.1;letter-spacing:-.01em;">
                Créer un compte
            </h1>
            <span style="display:inline-block;margin-top:.3rem;font-size:11px;font-weight:500;padding:.2rem .65rem;border-radius:20px;background:rgba(249,115,22,.1);color:#f97316;border:1px solid rgba(249,115,22,.22);">
                Inscription gratuite
            </span>
        </div>
    </div>

    <p style="font-size:.8125rem;color:#555;line-height:1.55;margin:0 0 1.4rem;">
        Rejoignez la plateforme en tant que <span style="color:#888;">donateur ou organisateur</span>
    </p>
</div>

{{-- ── Formulaire ── --}}
<form method="POST" action="{{ route('register') }}" class="fu-2">
    @csrf

    {{-- Nom --}}
    <div style="margin-bottom:1rem;">
        <label for="name" class="f-label">Nom complet</label>
        <div class="field-wrap" style="position:relative;">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus placeholder="Jean Dupont"
                   class="f-input" />
        </div>
        <x-input-error :messages="$errors->get('name')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    {{-- Email --}}
    <div style="margin-bottom:1rem;">
        <label for="email" class="f-label">Adresse e-mail</label>
        <div class="field-wrap" style="position:relative;">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required placeholder="votre@email.com"
                   class="f-input" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    {{-- Rôle — cards interactives --}}
    <div style="margin-bottom:1rem;">
        <label class="f-label">Je m'inscris en tant que</label>
        <div class="role-cards">

            {{-- Donateur --}}
            <label class="role-card">
                <input type="radio" name="role" value="donateur"
                       {{ old('role', 'donateur') == 'donateur' ? 'checked' : '' }} required />
                <div class="role-card-inner">
                    <div class="role-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <span class="role-label">Donateur</span>
                    <div class="role-dot"></div>
                </div>
            </label>

            {{-- Organisateur --}}
            <label class="role-card">
                <input type="radio" name="role" value="organisateur"
                       {{ old('role') == 'organisateur' ? 'checked' : '' }} />
                <div class="role-card-inner">
                    <div class="role-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                    </div>
                    <span class="role-label">Organisateur</span>
                    <div class="role-dot"></div>
                </div>
            </label>

        </div>
        <x-input-error :messages="$errors->get('role')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    <div class="row-sep"></div>

    {{-- Mot de passe --}}
    <div style="margin-bottom:1rem;">
        <label for="password" class="f-label">Mot de passe</label>
        <div class="field-wrap" style="position:relative;">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            <input id="password" type="password" name="password"
                   required placeholder="••••••••"
                   class="f-input f-input-pr"
                   oninput="updateStrength(this.value)" />
            <button type="button" class="pw-toggle" onclick="togglePw('password','eye1')" aria-label="Voir">
                <svg id="eye1" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
        {{-- Strength indicator --}}
        <div class="strength-bar" id="strength-bar">
            <div class="strength-seg" id="s1"></div>
            <div class="strength-seg" id="s2"></div>
            <div class="strength-seg" id="s3"></div>
            <div class="strength-seg" id="s4"></div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    {{-- Confirmer --}}
    <div style="margin-bottom:1.1rem;">
        <label for="password_confirmation" class="f-label">Confirmer le mot de passe</label>
        <div class="field-wrap" style="position:relative;">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required placeholder="••••••••"
                   class="f-input f-input-pr" />
            <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation','eye2')" aria-label="Voir">
                <svg id="eye2" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    {{-- Info banner organisateur --}}
    <div class="info-banner" id="org-notice" style="display:none;">
        <svg width="15" height="15" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
        <p>Les comptes <strong>organisateurs</strong> doivent être validés par un administrateur avant de pouvoir créer une cagnotte.</p>
    </div>

    {{-- CTA --}}
    <div style="margin-top:1.4rem;">
        <button type="submit" class="btn-cta">
            <span>Créer mon compte</span>
            <svg class="arrow" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
            </svg>
        </button>
    </div>

    {{-- Login link --}}
    <p class="fu-3" style="margin-top:1rem;text-align:center;font-size:.8125rem;color:#444;">
        Déjà inscrit ?
        <a href="{{ route('login') }}" class="link-o" style="margin-left:.25rem;font-weight:600;">
            Se connecter
        </a>
    </p>

</form>

<script>
// Toggle password visibility
function togglePw(inputId, iconId) {
    const inp = document.getElementById(inputId);
    const eye = document.getElementById(iconId);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    eye.style.color = show ? '#f97316' : '#333';
}

// Show/hide org notice based on role selection
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', () => {
        const notice = document.getElementById('org-notice');
        notice.style.display = radio.value === 'organisateur' && radio.checked ? 'flex' : 'none';
    });
});
// Init on load if old value
window.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="role"]:checked');
    if (checked && checked.value === 'organisateur') {
        document.getElementById('org-notice').style.display = 'flex';
    }
});

// Password strength indicator
function updateStrength(val) {
    const segs = [
        document.getElementById('s1'),
        document.getElementById('s2'),
        document.getElementById('s3'),
        document.getElementById('s4'),
    ];
    let score = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;

    const colors = ['#dc2626','#ea580c','#f97316','#22c55e'];
    segs.forEach((s, i) => {
        s.style.background = i < score ? colors[score - 1] : '#1c1c1c';
    });
}
</script>

</x-guest-layout>