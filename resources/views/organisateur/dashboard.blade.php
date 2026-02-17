@extends('layouts.dashboard')

@section('title', 'Dashboard Organisateur')
@section('page-title', 'Tableau de Bord Organisateur')

@section('content')
<div class="container">
    <h2>Mes Cagnottes</h2>

    @if($cagnottes->count() > 0)
        <div class="row mt-4">
            @foreach($cagnottes as $cagnotte)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if($cagnotte->image_path)
                            <img src="{{ asset('storage/' . $cagnotte->image_path) }}" class="card-img-top" alt="Cagnotte">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $cagnotte->title }}</h5>
                            <p class="card-text">{{ Str::limit($cagnotte->description, 100) }}</p>
                            <p>Collecté : {{ number_format($cagnotte->collected_amount, 0, ',', ' ') }} FCFA</p>
                            <p>Cible : {{ number_format($cagnotte->target_amount, 0, ',', ' ') }} FCFA</p>
                            <p>Status : <span class="badge 
                                @if($cagnotte->status == 'active') bg-success
                                @elseif($cagnotte->status == 'closed') bg-danger
                                @else bg-warning @endif">
                                {{ ucfirst($cagnotte->status) }}
                            </span></p>
                            <a href="{{ route('organisateur.cagnotte.edit', $cagnotte->id) }}" class="btn btn-sm btn-primary">Éditer</a>
                            <a href="{{ route('organisateur.cagnotte.show', $cagnotte->id) }}" class="btn btn-sm btn-info">Voir</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mt-3">
            Vous n'avez encore créé aucune cagnotte.
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('organisateur.cagnotte.create') }}" class="btn btn-success">Créer une Cagnotte</a>
    </div>
</div>
@endsection
