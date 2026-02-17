@extends('layouts.dashboard')

@section('title', 'Mes Cagnottes')
@section('page-title', 'Liste de Mes Cagnottes')

@section('content')
<div class="container">
    <h2>Mes Cagnottes</h2>

    @if($cagnottes->count() > 0)
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Montant Collecté</th>
                    <th>Cible</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cagnottes as $cagnotte)
                    <tr>
                        <td>{{ $cagnotte->id }}</td>
                        <td>{{ $cagnotte->title }}</td>
                        <td>{{ number_format($cagnotte->collected_amount, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($cagnotte->target_amount, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="badge 
                                @if($cagnotte->status == 'active') bg-success
                                @elseif($cagnotte->status == 'closed') bg-danger
                                @else bg-warning @endif">
                                {{ ucfirst($cagnotte->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('organisateur.cagnotte.edit', $cagnotte->id) }}" class="btn btn-sm btn-primary">Éditer</a>
                            <a href="{{ route('organisateur.cagnotte.show', $cagnotte->id) }}" class="btn btn-sm btn-info">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info mt-3">
            Vous n'avez encore créé aucune cagnotte.
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('organisateur.cagnotte.create') }}" class="btn btn-success">Créer une Nouvelle Cagnotte</a>
    </div>
</div>
@endsection
