@extends('layouts.dashboard')

@section('content')

<h1>Dashboard Admin</h1>

<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:20px;">

    <div>
        <h3>Total Dons</h3>
        <p>{{ number_format($totalDons, 0, ',', ' ') }} XOF</p>
    </div>

    <div>
        <h3>Total Commissions</h3>
        <p>{{ number_format($totalCommissions, 0, ',', ' ') }} XOF</p>
    </div>

    <div>
        <h3>Revenus ce mois</h3>
        <p>{{ number_format($revenusMois, 0, ',', ' ') }} XOF</p>
    </div>

    <div>
        <h3>Total Cagnottes</h3>
        <p>{{ $totalCagnottes }}</p>
    </div>

    <div>
        <h3>Total Utilisateurs</h3>
        <p>{{ $totalUtilisateurs }}</p>
    </div>

</div>

@endsection