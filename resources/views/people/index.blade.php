@extends('base')

@section('title', 'Liste des personnes')

@section('content')
    <h2>Liste des personnes</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td>{{ $person->last_name }}</td>
                    <td>{{ $person->first_name }}</td>
                    <td>{{ $person->createdBy->name }}</td>
                    <td><a href="{{ route('people.show', $person->id) }}">Voir</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
