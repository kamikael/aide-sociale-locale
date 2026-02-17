@extends('layouts.dashboard')

@section('title', 'Documents Organisateur')
@section('page-title', 'Mes Documents')

@section('content')
<div class="container">
    <h2>Documents pour Validation</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mt-3 mb-4">
        <div class="card-body">
            <form action="{{ route('organisateur.documents.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="document" class="form-label">Choisir un document (PDF ou image)</label>
                    <input type="file" class="form-control" id="document" name="document" required>
                </div>
                <button type="submit" class="btn btn-primary">Uploader</button>
            </form>
        </div>
    </div>

    <h4 class="mt-4">Mes Documents</h4>

    @if($documents->count() > 0)
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Fichier</th>
                    <th>Status</th>
                    <th>Validé par</th>
                    <th>Date Upload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                    <tr>
                        <td>{{ $doc->id }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                {{ basename($doc->file_path) }}
                            </a>
                        </td>
                        <td>
                            <span class="badge 
                                @if($doc->status == 'pending') bg-warning
                                @elseif($doc->status == 'approved') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($doc->status) }}
                            </span>
                        </td>
                        <td>
                            {{ $doc->validated_by ? $doc->validated_by : '—' }}
                        </td>
                        <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info mt-3">
            Aucun document uploadé pour le moment.
        </div>
    @endif
</div>
@endsection
