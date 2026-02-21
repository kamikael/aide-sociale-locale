@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-gray-800">Cagnottes Actives</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

    @foreach($cagnottes as $cagnotte)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
            <!-- Image ou placeholder -->
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-400">Image de la cagnotte</span>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $cagnotte['title'] }}</h2>

                </div>

                <p class="text-gray-600 mb-4">{{ $cagnotte['description'] }}</p>

                <!-- Progress bar -->
                @php
                    $progress = ($cagnotte['collected_amount'] / $cagnotte['target_amount']) * 100;
                @endphp
                <div class="w-full bg-gray-200 h-3 rounded-full mb-2">
                    <div class="h-3 rounded-full bg-blue-600" style="width: {{ $progress }}%;"></div>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    {{ number_format($cagnotte['collected_amount'], 0, ',', ' ') }} / {{ number_format($cagnotte['target_amount'], 0, ',', ' ') }} FCFA
                </p>

                <!-- Bouton -->
                <a href="/cagnottes/{{ $cagnotte['id'] }}" class="block text-center bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    Faire un don
                </a>
            </div>
        </div>
    @endforeach

</div>
@endsection

