<div class="p-3">
    <h4 class="text-white">Cagnotte</h4>
    <hr class="text-secondary">

    {{-- Menu Organisateur --}}
    @if(auth()->user()->role->name === 'organisateur')
        <a href="{{ route('organisateur.dashboard') }}">
            <i class="fa fa-chart-line"></i> Dashboard
        </a>

        <a href="{{ route('organisateur.cagnottes') }}">
            <i class="fa fa-hand-holding-heart"></i> Mes Cagnottes
        </a>

        <a href="{{ route('organisateur.documents') }}">
            <i class="fa fa-file-alt"></i> Documents
        </a>
    @endif

    {{-- Menu Admin --}}
    @if(auth()->user()->role->name === 'admin')
        <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-chart-pie"></i> Dashboard
        </a>

        <a href="{{ route('admin.validation.organisateurs') }}">
            <i class="fa fa-user-check"></i> Validation Organisateurs
        </a>

        <a href="{{ route('admin.paiements') }}">
            <i class="fa fa-money-bill-wave"></i> Paiements
        </a>

        <a href="{{ route('admin.statistiques') }}">
            <i class="fa fa-chart-bar"></i> Statistiques
        </a>
    @endif
</div>
