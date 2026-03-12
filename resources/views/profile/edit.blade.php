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
    .fu-4 { animation: fadeUp .4s .21s cubic-bezier(.22,1,.36,1) both; }

    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #444;
    }

    /* ── Section card ── */
    .profile-section {
        background: #0d0d0d; border: 1px solid #1a1a1a;
        border-radius: 18px; overflow: hidden;
    }
    .profile-section-header {
        display: flex; align-items: center; gap: .85rem;
        padding: 1.1rem 1.5rem; border-bottom: 1px solid #111;
    }
    .section-icon {
        width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .profile-section-body { padding: 1.5rem; }

    @media (max-width: 640px) {
        .profile-section-body { padding: 1.1rem; }
    }
</style>

<div class="page" style="max-width:680px;margin:0 auto;padding:1.75rem 1.25rem;display:flex;flex-direction:column;gap:1.35rem;">

    {{-- Header --}}
    <div class="fu">
        <p class="section-label" style="margin-bottom:.4rem;">Compte</p>
        <h1 class="dash-title" style="font-size:1.5rem;font-weight:800;color:#f0f0f0;margin:0;letter-spacing:-.02em;">
            Mon profil
        </h1>
    </div>

    {{-- User avatar strip --}}
    <div class="fu" style="display:flex;align-items:center;gap:1rem;
        padding:1rem 1.25rem;background:#0d0d0d;border:1px solid #1a1a1a;border-radius:14px;">
        <div style="width:48px;height:48px;border-radius:50%;flex-shrink:0;
            background:linear-gradient(135deg,rgba(220,38,38,.3),rgba(249,115,22,.25));
            border:1.5px solid rgba(249,115,22,.3);
            display:flex;align-items:center;justify-content:center;
            font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:800;color:#f97316;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div style="min-width:0;">
            <p style="font-size:.9375rem;font-weight:700;color:#e0e0e0;margin:0 0 .15rem;
                white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ auth()->user()->name }}
            </p>
            <p style="font-size:.775rem;color:#444;margin:0;
                white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ auth()->user()->email }}
            </p>
        </div>
        @php
    $roleRaw   = auth()->user()->role;
    // Si c'est un objet/model de relation, on extrait ->name
    $roleLabel = is_object($roleRaw)
        ? ($roleRaw->name ?? 'utilisateur')
        : ($roleRaw ?? 'utilisateur');
            $roleBg    = match($roleLabel) {
                'organisateur' => 'rgba(249,115,22,.1)',
                'admin'        => 'rgba(220,38,38,.1)',
                default        => 'rgba(100,100,100,.1)',
            };
            $roleColor = match($roleLabel) {
                'organisateur' => '#fb923c',
                'admin'        => '#f87171',
                default        => '#888',
            };
            $roleBorder = match($roleLabel) {
                'organisateur' => 'rgba(249,115,22,.25)',
                'admin'        => 'rgba(220,38,38,.25)',
                default        => '#222',
            };
        @endphp
        <span style="margin-left:auto;font-size:11px;font-weight:600;padding:.2rem .7rem;
            border-radius:20px;background:{{ $roleBg }};color:{{ $roleColor }};
            border:1px solid {{ $roleBorder }};white-space:nowrap;flex-shrink:0;">
            {{ ucfirst($roleLabel) }}
        </span>
    </div>

    {{-- Section 1: Profile info --}}
    <div class="profile-section fu-2">
        <div class="profile-section-header">
            <div class="section-icon" style="background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.18);">
                <svg width="13" height="13" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <div>
                <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">
                    Informations personnelles
                </h2>
                <p style="font-size:.75rem;color:#444;margin:0;">Nom et adresse e-mail</p>
            </div>
        </div>
        <div class="profile-section-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Section 2: Password --}}
    <div class="profile-section fu-3">
        <div class="profile-section-header">
            <div class="section-icon" style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.18);">
                <svg width="13" height="13" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>
            <div>
                <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#e0e0e0;margin:0 0 .1rem;">
                    Mot de passe
                </h2>
                <p style="font-size:.75rem;color:#444;margin:0;">Sécurisez votre accès</p>
            </div>
        </div>
        <div class="profile-section-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Section 3: Delete --}}
    <div class="profile-section fu-4" style="border-color:#1f1212;">
        <div class="profile-section-header" style="border-bottom-color:#1a1010;">
            <div class="section-icon" style="background:rgba(220,38,38,.08);border:1px solid rgba(220,38,38,.2);">
                <svg width="13" height="13" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                </svg>
            </div>
            <div>
                <h2 class="dash-title" style="font-size:.9rem;font-weight:700;color:#f87171;margin:0 0 .1rem;">
                    Zone dangereuse
                </h2>
                <p style="font-size:.75rem;color:#3a2020;margin:0;">Suppression définitive du compte</p>
            </div>
        </div>
        <div class="profile-section-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

</x-app-layout>