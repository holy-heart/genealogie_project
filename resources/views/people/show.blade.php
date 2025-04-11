@extends('base')

@section('title', 'Détail de la personne')

@section('content')
    <h2>{{ $person->first_name }} {{ $person->last_name }}</h2>

    <div style="margin-bottom: 20px;">
        <p><strong>Nom de naissance :</strong> {{ $person->birth_name ?? 'Non renseigné' }}</p>
        <p><strong>Deuxième(s) prénom(s) :</strong> {{ $person->middle_names ?? 'Non renseigné' }}</p>
        <p><strong>Date de naissance :</strong> {{ $person->date_of_birth ?? 'Non renseignée' }}</p>
    </div>

    <div style="margin-bottom: 20px;">
        <h3>Parents :</h3>
        @if($person->parents->isEmpty())
            <p style="font-style: italic;">Aucun parent enregistré.</p>
        @else
            <ul>
                @foreach($person->parents as $parent)
                    <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div style="margin-bottom: 20px;">
        <h3>Enfants :</h3>
        @if($person->children->isEmpty())
            <p style="font-style: italic;">Aucun enfant enregistré.</p>
        @else
            <ul>
                @foreach($person->children as $child)
                    <li>{{ $child->first_name }} {{ $child->last_name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div style="margin-bottom: 20px;">
        <h3>Action :</h3>
    @auth
        <div style="margin-top: 20px;">
            @if(auth()->user()->id === $person->created_by)
                <a href="{{ route('people.create', ['id' => $person->id]) }}" style="margin-right: 15px;">
                    Ajouter un membre de la famille
                </a>
            @else
                <p style="color: #a00; font-style: italic;">
                    Vous ne pouvez pas ajouter un membre à cette fiche, car vous n'en êtes pas le créateur.
                </p>
                <a href="{{ route('people.proposer', ['id' => $person->id]) }}">
                    Proposer une modification
                </a>
            @endif
        </div>
    @else
        <div style="margin-top: 20px;">
            <p style="color: #a00; font-style: italic;">
                Vous devez vous connecter pour ajouter un membre de VOTRE famille.
            </p>
            <p style="color: #a00; font-style: italic;">
                Vous devez être connecté pour proposer une modification.
            </p>
        </div>
    @endauth
    @auth
        @if(auth()->user()->id === $person->created_by)
            <h3>Code d'invitation (ce code est a transmetre a la personne qui doit gerer controle de ce profil)</h3>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {{ $person->id }}</p>
            <p>la personne pourra introduire ce code dans l'ongle "invité?", puis elle crera son compte, Attention, lorsequelle prendrea controle du profil
                vous ne pourrais plus que faire des proposition de lien    
            </p>
        @endif
    @endauth
    </div>
    <div>
        <a href="{{ route('people.index') }}">retour</a>
    </div>

@endsection
