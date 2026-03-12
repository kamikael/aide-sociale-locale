@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <section class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-800 shadow-xl">
        <div class="grid gap-6 px-6 py-8 text-white sm:px-8 lg:grid-cols-3 lg:items-center">
            <div class="lg:col-span-2">
                <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-white/70">
                    Administration
                </p>

                <h1 class="text-3xl font-bold leading-tight sm:text-4xl">
                    Tableau de bord administrateur
                </h1>

                <p class="mt-3 max-w-2xl text-sm text-white/85 sm:text-base">
                    Suivez l’activité globale de la plateforme, les validations en attente, les revenus et les performances des cagnottes.
                </p>
            </div>

            <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">
                <p class="text-sm text-white/75">Organisateurs en attente</p>
                <p class="mt-2 text-4xl font-bold">{{ $organisateursPending }}</p>
                <p class="mt-2 text-sm text-white/80">
                    Comptes à examiner et valider.
                </p>
            </div>
        </div>
    </section>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- KPI cards --}}
    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total dons validés</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-600">
                        {{ number_format($totalDons, 0, ',', ' ') }} FCFA
                    </p>
                </div>
                <div class="rounded-xl bg-emerald-100 px-3 py-2 text-emerald-700">
                    💰
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total commissions</p>
                    <p class="mt-3 text-3xl font-bold text-indigo-600">
                        {{ number_format($totalCommissions, 0, ',', ' ') }} FCFA
                    </p>
                </div>
                <div class="rounded-xl bg-indigo-100 px-3 py-2 text-indigo-700">
                    📈
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nombre de cagnottes</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ number_format($totalCagnottes, 0, ',', ' ') }}
                    </p>
                </div>
                <div class="rounded-xl bg-slate-100 px-3 py-2 text-slate-700">
                    🎯
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Utilisateurs inscrits</p>
                    <p class="mt-3 text-3xl font-bold text-blue-600">
                        {{ number_format($totalUtilisateurs, 0, ',', ' ') }}
                    </p>
                </div>
                <div class="rounded-xl bg-blue-100 px-3 py-2 text-blue-700">
                    👥
                </div>
            </div>
        </div>
    </section>

    {{-- Secondary cards --}}
    <section class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100 lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Résumé financier
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Vue rapide des performances économiques de la plateforme.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Revenus du mois</p>
                    <p class="mt-2 text-2xl font-bold text-indigo-600">
                        {{ number_format($revenusMois, 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Commissions générées</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-600">
                        {{ number_format($totalCommissions, 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Montant global des dons</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ number_format($totalDons, 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Dossiers en attente</p>
                    <p class="mt-2 text-2xl font-bold text-amber-600">
                        {{ number_format($organisateursPending, 0, ',', ' ') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h2 class="text-xl font-bold text-gray-900">
                Actions rapides
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Accédez directement aux tâches principales.
            </p>

            <div class="mt-6 space-y-4">
                <a
                    href="{{ route('admin.validation.organisateur') }}"
                    class="block rounded-2xl bg-indigo-600 px-5 py-4 text-sm font-semibold text-white shadow hover:bg-indigo-700"
                >
                    Voir les validations en attente
                </a>

                <a
                    href="{{ route('admin.validation.organisateur') }}"
                    class="block rounded-2xl bg-white px-5 py-4 text-sm font-semibold text-gray-900 ring-1 ring-gray-200 shadow-sm hover:bg-gray-50"
                >
                    Examiner les documents déposés
                </a>
            </div>

            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
                <p class="text-sm font-semibold">
                    Priorité du jour
                </p>
                <p class="mt-1 text-sm">
                    {{ $organisateursPending }} organisateur(s) attendent une décision administrative.
                </p>
            </div>
        </div>
    </section>

    {{-- Activity overview --}}
    <section class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h2 class="text-xl font-bold text-gray-900">
                Indicateurs clés
            </h2>

            <div class="mt-6 space-y-5">
                <div>
                    <div class="mb-2 flex items-center justify-between text-sm">
                        <span class="text-gray-600">Progression des validations</span>
                        <span class="font-semibold text-gray-900">
                            {{ $organisateursPending }} en attente
                        </span>
                    </div>
                    <div class="h-3 w-full rounded-full bg-gray-200">
                        <div class="h-3 rounded-full bg-amber-500" style="width: {{ min(100, $organisateursPending * 10) }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between text-sm">
                        <span class="text-gray-600">Performance commissions</span>
                        <span class="font-semibold text-gray-900">
                            {{ number_format($totalCommissions, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                    <div class="h-3 w-full rounded-full bg-gray-200">
                        <div class="h-3 rounded-full bg-indigo-600" style="width: 75%"></div>
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between text-sm">
                        <span class="text-gray-600">Volume des dons</span>
                        <span class="font-semibold text-gray-900">
                            {{ number_format($totalDons, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                    <div class="h-3 w-full rounded-full bg-gray-200">
                        <div class="h-3 rounded-full bg-emerald-600" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h2 class="text-xl font-bold text-gray-900">
                Vue globale
            </h2>

            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="rounded-2xl bg-slate-50 p-5 text-center ring-1 ring-slate-100">
                    <p class="text-sm text-gray-500">Cagnottes</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalCagnottes }}</p>
                </div>

                <div class="rounded-2xl bg-blue-50 p-5 text-center ring-1 ring-blue-100">
                    <p class="text-sm text-blue-700">Utilisateurs</p>
                    <p class="mt-2 text-2xl font-bold text-blue-700">{{ $totalUtilisateurs }}</p>
                </div>

                <div class="rounded-2xl bg-emerald-50 p-5 text-center ring-1 ring-emerald-100">
                    <p class="text-sm text-emerald-700">Dons validés</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-700">
                        {{ number_format($totalDons, 0, ',', ' ') }}
                    </p>
                </div>

                <div class="rounded-2xl bg-amber-50 p-5 text-center ring-1 ring-amber-100">
                    <p class="text-sm text-amber-700">En attente</p>
                    <p class="mt-2 text-2xl font-bold text-amber-700">{{ $organisateursPending }}</p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection