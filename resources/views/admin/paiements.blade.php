@extends('layouts.dashboard')

@section('title', 'Liste Paiements')
@section('page-title', 'Transactions Mobile Money')

@section('content')
<div class="container">
    <h2>Liste des Paiements</h2>

    @if($paiements->count() > 0)
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Transaction Référence</th>
                    <th>Montant (FCFA)</th>
                    <th>Fournisseur</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>{{ $paiement->transaction_reference }}</td>
                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }}</td>
                        <td>{{ $paiement->provider->name }}</td>
                        <td>
                            @if($paiement->status === 'success')
                                <span class="badge bg-success">Succès</span>
                            @elseif($paiement->status === 'pending')
                                <span class="badge bg-warning">En attente</span>
                            @else
                                <span class="badge bg-danger">Échec</span>
                            @endif
                        </td>
                        <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info mt-3">
            Aucune transaction enregistrée.
        </div>
    @endif
</div>
@endsection
