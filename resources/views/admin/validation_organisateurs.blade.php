@extends('layouts.dashboard')

@section('title', 'Validation Organisateurs')
@section('page-title', 'Validation des Organisateurs')

@section('content')
<div class="container">
    <h2>Validation des Organisateurs</h2>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($organisateurs->count() > 0)
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($organisateurs as $organisateur)
                    <tr>
                        <td>{{ $organisateur->id }}</td>
                        <td>{{ $organisateur->name }}</td>
                        <td>{{ $organisateur->email }}</td>
                        <td>
                            {{-- Valider --}}
                            <form action="{{ route('admin.organisateur.approve', $organisateur->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approuver</button>
                            </form>

                            {{-- Rejeter --}}
                            <form action="{{ route('admin.organisateur.reject', $organisateur->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info mt-3">
            Aucun organisateur en attente.
        </div>
    @endif
</div>
@endsection
