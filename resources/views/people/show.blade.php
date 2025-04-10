@extends('base')

@section('title', 'Détail de la personne')

@section('content')
    <h2>{{ $person->first_name }} {{ $person->last_name }}</h2>

    <p><strong>Nom de naissance :</strong> {{ $person->birth_name }}</p>
    <p><strong>Deuxième(s) prénom(s) :</strong> {{ $person->middle_names }}</p>
    <p><strong>Date de naissance :</strong> {{ $person->date_of_birth }}</p>

    <h3>Parents :</h3>
    @if($person->parents->isEmpty())
        <p>Aucun parent enregistré.</p>
    @else
        <ul>
            @foreach($person->parents as $parent)
                <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
            @endforeach
        </ul>
    @endif

    <h3>Enfants :</h3>
    @if($person->children->isEmpty())
        <p>Aucun enfant enregistré.</p>
    @else
        <ul>
            @foreach($person->children as $child)
                <li>{{ $child->first_name }} {{ $child->last_name }}</li>
            @endforeach
        </ul>
    @endif
    @auth
        @if(auth()->user()->id === $person->created_by)
            <a href="{{ route('people.create', ['id' => $person->id]) }}">ajouter un membre de la fammille</a>
        @endif
        <br>
        <a href="{{ route('people.proposer', ['id'=>$person->id])}}">proposer une modification</a>

    @endauth
@endsection
