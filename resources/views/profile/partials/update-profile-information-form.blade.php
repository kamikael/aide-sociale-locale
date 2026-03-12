<style>
    .pf-label {
        display: block; font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .1em; color: #555; margin-bottom: .5rem;
    }
    .pf-wrap { position: relative; }
    .pf-icon {
        position: absolute; left: .85rem; top: 50%;
        transform: translateY(-50%); pointer-events: none; color: #333;
        transition: color .2s;
    }
    .pf-wrap:focus-within .pf-icon { color: #f97316; }
    .pf-input {
        width: 100%; background: #0a0a0a; border: 1px solid #1e1e1e;
        color: #e0e0e0; border-radius: 11px;
        padding: .75rem 1rem .75rem 2.6rem;
        font-size: .875rem; font-family: 'DM Sans', sans-serif;
        outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .pf-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); }
    .pf-input::placeholder { color: #2e2e2e; }
    .pf-error { font-size: .775rem; color: #fca5a5; margin-top: .35rem; }
    .pf-help  { font-size: .775rem; color: #3a3a3a; margin-top: .35rem; line-height: 1.5; }
    .pf-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .7rem 1.35rem; border-radius: 10px; border: none;
        background: linear-gradient(135deg, #dc2626, #f97316);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .8375rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 14px rgba(220,38,38,.25);
        transition: filter .2s, transform .15s;
    }
    .pf-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }
    .pf-btn:active { transform: translateY(0); }
    .pf-saved {
        display: inline-flex; align-items: center; gap: .35rem;
        font-size: .8rem; font-weight: 600; color: #4ade80;
    }
    .unverified-banner {
        display: flex; align-items: flex-start; gap: .6rem;
        padding: .75rem .9rem; border-radius: 10px;
        background: rgba(251,191,36,.06); border: 1px solid rgba(251,191,36,.2);
        font-size: .8rem; color: #b45309; line-height: 1.55;
    }
    .unverified-banner a { color: #fbbf24; font-weight: 600; text-decoration: underline; background: none; border: none; cursor: pointer; font-family: inherit; font-size: inherit; }
</style>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

<form method="post" action="{{ route('profile.update') }}"
      style="display:flex;flex-direction:column;gap:1.1rem;">
    @csrf
    @method('patch')

    {{-- Nom --}}
    <div>
        <label for="name" class="pf-label">Nom complet</label>
        <div class="pf-wrap">
            <svg class="pf-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <input id="name" name="name" type="text"
                   class="pf-input"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   placeholder="Votre nom" />
        </div>
        @error('name')
            <p class="pf-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="pf-label">Adresse e-mail</label>
        <div class="pf-wrap">
            <svg class="pf-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
            <input id="email" name="email" type="email"
                   class="pf-input"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   placeholder="votre@email.com" />
        </div>
        @error('email')
            <p class="pf-error">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="unverified-banner" style="margin-top:.6rem;">
                <svg width="14" height="14" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                <span>
                    Adresse e-mail non vérifiée.
                    <button form="send-verification">Renvoyer le lien de vérification.</button>
                </span>
            </div>
            @if (session('status') === 'verification-link-sent')
                <p style="font-size:.775rem;color:#4ade80;margin-top:.4rem;font-weight:500;">
                    Lien de vérification envoyé.
                </p>
            @endif
        @endif
    </div>

    {{-- Submit --}}
    <div style="display:flex;align-items:center;gap:.85rem;padding-top:.25rem;">
        <button type="submit" class="pf-btn">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Enregistrer
        </button>
        @if (session('status') === 'profile-updated')
            <span class="pf-saved"
                  x-data="{ show: true }"
                  x-show="show" x-transition
                  x-init="setTimeout(() => show = false, 2500)">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                Sauvegardé
            </span>
        @endif
    </div>
</form>