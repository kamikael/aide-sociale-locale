@extends('layouts.dashboard')

@section('content')

<h1>Dashboard Organisateur</h1>

<p>Nombre de cagnottes : {{ $nombreCagnottes }}</p>

<p>Montant total collecté :
    {{ number_format($montantTotalCollecte, 0, ',', ' ') }} XOF
</p>

<a href="{{ route('organisateur.cagnottes') }}">
    Voir mes cagnottes
</a>

@endsection