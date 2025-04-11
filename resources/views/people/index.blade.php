@extends('base')

@section('title', 'Liste des personnes')

@section('content')
    <h2>Liste des personnes</h2>
    
    
    @auth
        <div style="background-color: #d4edda; color: #155724; padding: 1px; margin-bottom: 10px; border: 1px solid #c3e6cb;">
            <p>vous pouvez maintennant ajouter des membre de votre famille, uniquement pour les profil dont vous étes le gerant (Utilisateur = {{ auth()->user()->name }}),
                vous pouver par contre proposer une relation pour les autre personnes, il seront soit validé par l'une des concerné,
                ou alors validé par 3 person de la comunauté, elle peuvent de la meme facon etre refusé.
            </p>
        </div>
    @endauth

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($people as $person)
                <tr>
                    <td>{{ $person->last_name }}</td>
                    <td>{{ $person->first_name }}</td>
                    <td>{{ $person->createdBy->name }}</td>
                    <td><a href="{{ route('people.show', $person->id) }}">Voir</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Aucune personne trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
