@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Historique des dons</h1>

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-3 text-left">Cagnotte</th>
            <th class="p-3 text-left">Montant</th>
            <th class="p-3 text-left">Date</th>
            <th class="p-3 text-left">Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dons as $don)
            <tr class="border-t">
                <td class="p-3">{{ $don->cagnotte->title }}</td>
                <td class="p-3">
                    {{ number_format($don->montant, 0, ',', ' ') }} XOF
                </td>
                <td class="p-3">
                    {{ $don->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="p-3 text-green-600">
                    {{ $don->paiement->status }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-6">
    {{ $dons->links() }}
</div>

@endsection