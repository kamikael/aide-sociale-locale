@extends('layouts.dashboard')

@section('content')

<h1>Validation Organisateurs</h1>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Date inscription</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($organisateurs as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <form method="POST"
                          action="{{ route('admin.organisateur.approve', $user) }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit">Approuver</button>
                    </form>

                    <form method="POST"
                          action="{{ route('admin.organisateur.reject', $user) }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit">Rejeter</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $organisateurs->links() }}

@endsection