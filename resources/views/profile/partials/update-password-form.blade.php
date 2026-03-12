<style>
    .pw-strength { display:flex; gap:.3rem; margin-top:.55rem; }
    .pw-seg {
        flex: 1; height: 3px; border-radius: 3px;
        background: #1a1a1a; transition: background .3s;
    }
    .pw-seg.s1 { background: #f87171; }
    .pw-seg.s2 { background: #fb923c; }
    .pw-seg.s3 { background: #fbbf24; }
    .pw-seg.s4 { background: #4ade80; }
    .pw-toggle {
        position: absolute; right: .85rem; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #333; padding: .2rem; transition: color .2s;
        display: flex; align-items: center;
    }
    .pw-toggle:hover { color: #f97316; }
</style>

<form method="post" action="{{ route('password.update') }}"
      style="display:flex;flex-direction:column;gap:1.1rem;">
    @csrf
    @method('put')

    {{-- Current password --}}
    <div>
        <label for="update_password_current_password" class="pf-label">Mot de passe actuel</label>
        <div class="pf-wrap">
            <svg class="pf-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            <input id="update_password_current_password"
                   name="current_password" type="password"
                   class="pf-input" style="padding-right:2.8rem;"
                   autocomplete="current-password"
                   placeholder="••••••••" />
            <button type="button" class="pw-toggle" onclick="togglePw('update_password_current_password', this)">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
        @error('current_password', 'updatePassword')
            <p class="pf-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- New password --}}
    <div>
        <label for="update_password_password" class="pf-label">Nouveau mot de passe</label>
        <div class="pf-wrap">
            <svg class="pf-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
            </svg>
            <input id="update_password_password"
                   name="password" type="password"
                   class="pf-input" style="padding-right:2.8rem;"
                   autocomplete="new-password"
                   placeholder="Minimum 8 caractères"
                   oninput="checkStrength(this.value)" />
            <button type="button" class="pw-toggle" onclick="togglePw('update_password_password', this)">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
        <div class="pw-strength" id="pw-strength">
            <div class="pw-seg" id="ps1"></div>
            <div class="pw-seg" id="ps2"></div>
            <div class="pw-seg" id="ps3"></div>
            <div class="pw-seg" id="ps4"></div>
        </div>
        @error('password', 'updatePassword')
            <p class="pf-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Confirm password --}}
    <div>
        <label for="update_password_password_confirmation" class="pf-label">Confirmer le mot de passe</label>
        <div class="pf-wrap">
            <svg class="pf-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
            </svg>
            <input id="update_password_password_confirmation"
                   name="password_confirmation" type="password"
                   class="pf-input" style="padding-right:2.8rem;"
                   autocomplete="new-password"
                   placeholder="Répétez le mot de passe" />
            <button type="button" class="pw-toggle" onclick="togglePw('update_password_password_confirmation', this)">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
        @error('password_confirmation', 'updatePassword')
            <p class="pf-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Submit --}}
    <div style="display:flex;align-items:center;gap:.85rem;padding-top:.25rem;">
        <button type="submit" class="pf-btn">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            Mettre à jour
        </button>
        @if (session('status') === 'password-updated')
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

<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    if (!input) return;
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.innerHTML = isText
        ? `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
        : `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>`;
}

function checkStrength(val) {
    const segs = [
        document.getElementById('ps1'),
        document.getElementById('ps2'),
        document.getElementById('ps3'),
        document.getElementById('ps4'),
    ];
    segs.forEach(s => { s.className = 'pw-seg'; });
    if (!val) return;
    let score = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;
    const cls = ['s1','s2','s3','s4'];
    for (let i = 0; i < score; i++) segs[i].classList.add(cls[score - 1]);
}
</script>