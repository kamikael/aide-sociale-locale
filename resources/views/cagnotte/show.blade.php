@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">

    <!-- Image de la cagnotte -->
    <div class="h-64 bg-gray-200 flex items-center justify-center">
        <span class="text-gray-400 text-lg">Image de la cagnotte</span>
    </div>

    <div class="p-8">

        <!-- Titre et description -->
        <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $cagnotte['title'] }}</h1>
        <p class="text-gray-700 mb-6">{{ $cagnotte['description'] }}</p>

        <!-- Progress bar -->
        @php
            $progress = ($cagnotte['collected_amount'] / $cagnotte['target_amount']) * 100;
        @endphp
        <div class="w-full bg-gray-200 h-4 rounded-full mb-2">
            <div class="h-4 rounded-full bg-blue-600" style="width: {{ $progress }}%;"></div>
        </div>
        <p class="text-gray-600 mb-6 font-medium">
            {{ number_format($cagnotte['collected_amount'], 0, ',', ' ') }} / {{ number_format($cagnotte['target_amount'], 0, ',', ' ') }} FCFA collectés
        </p>

        <!-- Bouton Faire un don -->
        <a href="#" class="inline-block bg-green-500 text-white font-semibold px-6 py-3 rounded-lg hover:bg-green-600 transition-colors duration-300 mb-8">
            Faire un don
        </a>

        <!-- Dons récents (mock) -->
        <div>
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Dons récents</h2>
            <ul class="space-y-3">
                <li class="flex justify-between p-4 bg-gray-50 rounded shadow-sm hover:shadow-md transition-shadow duration-200">
                    <span>Jean D.</span>
                    <span class="font-medium">50 000 FCFA</span>
                </li>
                <li class="flex justify-between p-4 bg-gray-50 rounded shadow-sm hover:shadow-md transition-shadow duration-200">
                    <span>Fatou S.</span>
                    <span class="font-medium">20 000 FCFA</span>
                </li>
                <li class="flex justify-between p-4 bg-gray-50 rounded shadow-sm hover:shadow-md transition-shadow duration-200">
                    <span>Aliou K.</span>
                    <span class="font-medium">35 000 FCFA</span>
                </li>
            </ul>
        </div>

        <!-- Retour aux cagnottes -->
        <a href="/cagnottes" class="inline-block mt-6 text-blue-600 hover:underline">← Retour aux cagnottes</a>
    </div>

</div>
@endsection
