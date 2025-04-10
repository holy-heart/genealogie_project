<?php

use App\Models\Person;

?>

@extends('base')

@section('title', 'Liste des propositions')

@section('content')
    <div>
        <table>
            <thead>
                <tr>
                    <th>Nom de la personne</th>
                    <th>Lien</th>
                    <th>Personne liée</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $R = session('Rela', []);
                @endphp
                @foreach($R as $index => $relation)
                @php
                    $person1 = Person::find($relation['person']);
                    $person2 = Person::find($relation['person2']);
                @endphp
                @if($person1 && $person2)

                        <tr>
                            <td>{{ $person1->last_name}} {{ $person1->first_name }}</td>
                            <td>{{ $relation['link'] }} de </td>
                            <td>{{ $person2->last_name }} {{ $person2->first_name }}</td>
                            <td>
                                <a href="{{ route('people.valider', ['p' => $relation['person'], 'link' => $relation['link'], 'p2' => $relation['person2']]) }}">
                                    Validate
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('people.refuser', ['p' => $relation['person'], 'link' => $relation['link'], 'p2' => $relation['person2']]) }}">
                                    refuser
                                </a>
                            </td>
                        </tr>
                    
                @else
                    @php
                        // Remove invalid entry from the session
                        unset($R[$index]);
                        session(['Rela' => array_values($R)]);
                    @endphp
                @endif
                
                @endforeach

            </tbody>
        </table>
    </div>
@endsection