<x-guest-layout>

<style>
    .login-title { font-family: 'Syne', sans-serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fu-1 { animation: fadeUp .4s .05s cubic-bezier(.22,1,.36,1) both; }
    .fu-2 { animation: fadeUp .4s .12s cubic-bezier(.22,1,.36,1) both; }
    .fu-3 { animation: fadeUp .4s .2s  cubic-bezier(.22,1,.36,1) both; }

    /* Inputs */
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

    /* Input avec action droite (password toggle) */
    .f-input-pr { padding-right: 2.8rem; }

    /* Icône champ */
    .field-icon {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        color: #333;
        pointer-events: none;
        transition: color .2s;
    }
    .field-wrap:focus-within .field-icon { color: #f97316; }

    /* Toggle password */
    .pw-toggle {
        position: absolute;
        right: .85rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        color: #333;
        line-height: 0;
        transition: color .2s;
    }
    .pw-toggle:hover { color: #f97316; }

    /* Label */
    .f-label {
        display: block;
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #555;
        margin-bottom: .45rem;
    }

    /* Checkbox */
    .c-box {
        appearance: none;
        width: 15px;
        height: 15px;
        border: 1.5px solid #2a2a2a;
        border-radius: 4px;
        background: #0a0a0a;
        cursor: pointer;
        flex-shrink: 0;
        position: relative;
        transition: background .2s, border-color .2s;
        margin-top: 1px;
    }
    .c-box:checked {
        background: linear-gradient(135deg, #dc2626, #f97316);
        border-color: transparent;
    }
    .c-box:checked::after {
        content: '';
        position: absolute;
        top: 2px; left: 4.5px;
        width: 4px; height: 7px;
        border: 1.5px solid #fff;
        border-top: none;
        border-left: none;
        transform: rotate(45deg);
    }
    .c-box:focus { box-shadow: 0 0 0 3px rgba(249,115,22,.18); outline: none; }

    /* Bouton CTA */
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

    /* Liens */
    .link-o {
        color: #f97316;
        text-decoration: none;
        font-weight: 500;
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

    /* Error */
    .error-box {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        padding: .75rem 1rem;
        border-radius: 10px;
        background: rgba(220,38,38,.08);
        border: 1px solid rgba(220,38,38,.22);
        margin-bottom: 1.25rem;
    }
    .error-box p { font-size: .8125rem; color: #fca5a5; margin: 0; line-height: 1.5; }
</style>

{{-- ── Header ── --}}
<div class="fu-1">
    {{-- Accent line --}}
    <div style="height:2px;border-radius:2px;background:linear-gradient(90deg,#dc2626,#f97316,transparent);margin-bottom:1.5rem;"></div>

    <div style="display:flex;align-items:center;gap:.85rem;margin-bottom:.75rem;">
        {{-- Icône shield --}}
        <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#dc2626,#f97316);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(220,38,38,.35);">
            <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 2.25 2.25 0 012.25 8.125V15a6.75 6.75 0 006.328 6.732 11.93 11.93 0 005.197-2.337m0 0a11.957 11.957 0 01-5.197-9.42 2.25 2.25 0 00-1.356-2.03A11.959 11.959 0 0112 2.25"/>
            </svg>
        </div>
        <div>
            <h1 class="login-title" style="font-size:1.35rem;font-weight:800;color:#f0f0f0;margin:0;line-height:1.1;letter-spacing:-.01em;">
                Connexion
            </h1>
            <span style="display:inline-block;margin-top:.3rem;font-size:11px;font-weight:500;padding:.2rem .65rem;border-radius:20px;background:rgba(249,115,22,.1);color:#f97316;border:1px solid rgba(249,115,22,.22);">
                Espace sécurisé
            </span>
        </div>
    </div>

    <p style="font-size:.8125rem;color:#555;line-height:1.55;margin:0 0 1.5rem;">
        Accédez à votre espace <span style="color:#888;">donateur ou organisateur</span>
    </p>
</div>

{{-- Session status --}}
<x-auth-session-status class="mb-4" :status="session('status')" />

{{-- Error --}}
@if(session('error'))
<div class="error-box fu-1">
    <svg width="15" height="15" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
    </svg>
    <p>{{ session('error') }}</p>
</div>
@endif

{{-- ── Formulaire ── --}}
<form method="POST" action="{{ route('login') }}" class="fu-2">
    @csrf

    {{-- Email --}}
    <div style="margin-bottom:1.1rem;">
        <label for="email" class="f-label">Adresse e-mail</label>
        <div class="field-wrap" style="position:relative;">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="votre@email.com"
                   class="f-input" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    {{-- Password --}}
    <div style="margin-bottom:1.25rem;">
        <label for="password" class="f-label">Mot de passe</label>
        <div class="field-wrap" style="position:relative;">
            <svg class="field-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="f-input f-input-pr" />
            <button type="button" class="pw-toggle" onclick="togglePw()" aria-label="Voir le mot de passe">
                <svg id="pw-eye" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1" style="font-size:.75rem;color:#fca5a5;" />
    </div>

    {{-- Remember + Forgot --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem;gap:.5rem;">
        <label for="remember_me" style="display:flex;align-items:center;gap:.55rem;cursor:pointer;">
            <input id="remember_me" type="checkbox" name="remember" class="c-box" />
            <span style="font-size:.8125rem;color:#555;user-select:none;">Se souvenir de moi</span>
        </label>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="link-o" style="font-size:.8125rem;white-space:nowrap;">
                Mot de passe oublié&nbsp;?
            </a>
        @endif
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-cta">
        <span>Se connecter</span>
        <svg class="arrow" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
    </button>

    {{-- Register --}}
    <p class="fu-3" style="margin-top:1.1rem;text-align:center;font-size:.8125rem;color:#444;">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="link-o" style="margin-left:.25rem;font-weight:600;">
            Créer un compte
        </a>
    </p>

</form>

<script>
function togglePw() {
    const inp = document.getElementById('password');
    const eye = document.getElementById('pw-eye');
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    eye.style.color = show ? '#f97316' : '#333';
}
</script>

</x-guest-layout>