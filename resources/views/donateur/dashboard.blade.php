@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Mon Dashboard</h1>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">Total Donné</h2>
        <p class="text-2xl mt-2 text-green-600">
            {{ number_format($totalDons, 0, ',', ' ') }} XOF
        </p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">Nombre de Dons</h2>
        <p class="text-2xl mt-2">
            {{ $nombreDons }}
        </p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">Dernier Don</h2>
        <p class="mt-2">
            @if($dernierDon)
                {{ $dernierDon->cagnotte->title }} <br>
                {{ number_format($dernierDon->montant, 0, ',', ' ') }} XOF
            @else
                Aucun don effectué
            @endif
        </p>
    </div>

</div>

@endsection