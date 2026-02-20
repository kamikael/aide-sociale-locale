@extends('layouts.dashboard')

@section('content')

<h1>Mes Cagnottes</h1>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Objectif</th>
            <th>Collecté</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cagnottes as $cagnotte)
            <tr>
                <td>{{ $cagnotte->title }}</td>
                <td>{{ $cagnotte->target_amount }}</td>
                <td>{{ $cagnotte->collected_amount }}</td>
                <td>{{ $cagnotte->status }}</td>
                <td>
                    <a href="{{ route('cagnottes.edit', $cagnotte) }}">Modifier</a>

                    <form method="POST"
                          action="{{ route('organisateur.cagnottes.destroy', $cagnotte) }}"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $cagnottes->links() }}

@endsection