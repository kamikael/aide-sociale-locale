@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Tableau de Bord Administrateur')

@section('content')
<div class="container">
    <h2>Dashboard Admin</h2>
    <div class="row mt-4">

        {{-- Total Cagnottes --}}
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h5>Total Cagnottes</h5>
                <h3>{{ $totalCagnottes }}</h3>
            </div>
        </div>

        {{-- Total Collecté --}}
        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h5>Total Collecté</h5>
                <h3>{{ number_format($totalCollected, 0, ',', ' ') }} FCFA</h3>
            </div>
        </div>

        {{-- Cagnottes Actives --}}
        <div class="col-md-3">
            <div class="card bg-warning text-white p-3">
                <h5>Cagnottes Actives</h5>
                <h3>{{ $activeCagnottes }}</h3>
            </div>
        </div>

        {{-- Cagnottes Fermées --}}
        <div class="col-md-3">
            <div class="card bg-danger text-white p-3">
                <h5>Cagnottes Fermées</h5>
                <h3>{{ $closedCagnottes }}</h3>
            </div>
        </div>

    </div>
</div>
@endsection
