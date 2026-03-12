<style>
    /* Delete modal overlay */
    .del-overlay {
        display: none; position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,.85); backdrop-filter: blur(8px);
        align-items: center; justify-content: center; padding: 1rem;
    }
    .del-overlay.open { display: flex; }
    .del-modal {
        background: #0d0d0d; border: 1px solid #2a1010;
        border-radius: 18px; width: 100%; max-width: 440px;
        padding: 2rem; position: relative;
        animation: fadeUp .35s cubic-bezier(.22,1,.36,1) both;
    }
    .del-modal-icon {
        width: 48px; height: 48px; border-radius: 13px; margin-bottom: 1.1rem;
        background: rgba(220,38,38,.12); border: 1px solid rgba(220,38,38,.25);
        display: flex; align-items: center; justify-content: center;
    }
    .btn-danger {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1.15rem; border-radius: 10px; border: none;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .8375rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 12px rgba(220,38,38,.3);
        transition: filter .2s, transform .15s;
    }
    .btn-danger:hover { filter: brightness(1.1); transform: translateY(-1px); }
    .btn-danger:active { transform: translateY(0); }
    .btn-danger-outline {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1.15rem; border-radius: 10px;
        border: 1px solid #1e1e1e; background: transparent;
        color: #666; font-family: 'DM Sans', sans-serif;
        font-size: .8375rem; font-weight: 500; cursor: pointer;
        transition: color .2s, border-color .2s, background .2s;
    }
    .btn-danger-outline:hover { color: #ccc; border-color: #2a2a2a; background: rgba(255,255,255,.04); }
    .btn-open-danger {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .65rem 1.2rem; border-radius: 10px;
        border: 1px solid rgba(220,38,38,.25); background: rgba(220,38,38,.06);
        color: #f87171; font-family: 'DM Sans', sans-serif;
        font-size: .8375rem; font-weight: 600; cursor: pointer;
        transition: background .2s, border-color .2s;
    }
    .btn-open-danger:hover { background: rgba(220,38,38,.1); border-color: rgba(220,38,38,.4); }
</style>

{{-- Warning text --}}
<p style="font-size:.8375rem;color:#4a2020;line-height:1.65;margin:0 0 1.25rem;">
    Une fois votre compte supprimé, toutes vos données seront définitivement effacées.
    Cette action est <strong style="color:#f87171;">irréversible</strong>.
</p>

{{-- Trigger button --}}
<button type="button" class="btn-open-danger" onclick="document.getElementById('del-overlay').classList.add('open')">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
    </svg>
    Supprimer mon compte
</button>

{{-- Modal overlay --}}
<div id="del-overlay" class="del-overlay" onclick="if(event.target===this)closeDelModal()">
    <div class="del-modal">

        <div class="del-modal-icon">
            <svg width="22" height="22" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>

        <h2 class="dash-title" style="font-size:1.1rem;font-weight:800;color:#f0f0f0;margin:0 0 .6rem;">
            Confirmer la suppression
        </h2>
        <p style="font-size:.8125rem;color:#555;line-height:1.65;margin:0 0 1.5rem;">
            Cette action supprimera définitivement votre compte et toutes vos données.
            Entrez votre mot de passe pour confirmer.
        </p>

        <form method="post" action="{{ route('profile.destroy') }}"
              style="display:flex;flex-direction:column;gap:1rem;">
            @csrf
            @method('delete')

            <div>
                <label class="pf-label" style="margin-bottom:.5rem;">Mot de passe</label>
                <div class="pf-wrap">
                    <svg class="pf-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    <input id="del-password" name="password" type="password"
                           class="pf-input"
                           placeholder="Votre mot de passe actuel"
                           style="border-color:rgba(220,38,38,.2);" />
                </div>
                @error('password', 'userDeletion')
                    <p class="pf-error">{{ $message }}</p>
                @enderror
            </div>

            <div style="display:flex;align-items:center;justify-content:flex-end;gap:.65rem;padding-top:.25rem;">
                <button type="button" class="btn-danger-outline" onclick="closeDelModal()">
                    Annuler
                </button>
                <button type="submit" class="btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                    Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    <script>document.getElementById('del-overlay').classList.add('open');</script>
@endif

<script>
function closeDelModal() {
    document.getElementById('del-overlay').classList.remove('open');
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDelModal();
});
</script>